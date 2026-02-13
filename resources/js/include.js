function loadComponent(id, file, callback) {
  fetch(file)
    .then(res => res.text())
    .then(data => {
      document.getElementById(id).innerHTML = data;
      if (callback) callback();
    })
    .catch(err => console.log("Error loading:", file));
}

// header load
loadComponent("header", "components/header.html", () => {
  const script = document.createElement("script");
  script.src = "js/header.js";
  document.body.appendChild(script);
});

// footer load
loadComponent("footer", "components/footer.html");
