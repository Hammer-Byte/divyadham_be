<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Donations</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/donation.css') }}" />
</head>

<body>

    <!-- Header -->
    @include('components.header')

    <!-- PAGE BANNER -->
    <section class="page-banner">
        <h2>
            Donations
        </h2>
        <img src="{{ asset('images/divine_img.png') }}" alt="Divine Image" class="banner-image">
    </section>
    <section class="donation-section">
        <div class="container donation-content">
            <div class="donation-info">
                <h2>Donation Policy</h2>
                <p>
                    The donation to Divyadham - Valaradi Temple is the main source of income. The donations made by the
                    devotees are used to maintain the temple premises and provide infrastructure. All the facilities
                    provided in the temple premises to the devotees are fulfilled only from the income of donations.
                </p>
                <p>
                    Divyadham Mandir Trust - Valaradi is carrying out socially useful service functions such as
                    educational work, agricultural programs, settlement commission, marriage bureau, women empowerment,
                    sports and natural calamity relief. Donations received by devotees to the Divyadham Mandir Trust -
                    Valaradi are utilized for such social development activities.
                </p>
                <div class="divine-box">
                    Any kind of Donation provided to trust is not Refundable/Cancellable. Trust don't follow any kind of
                    Refundable/Cancellable Policy.
                </div>
                <h2>Donation Services & Rates</h2>
                <div class="seva-section">
                    <table class="seva-table">
                        <thead>
                            <tr>
                                <th class="col-no">No.</th>
                                <th class="col-desc">Service Description</th>
                                <th class="col-amt">Amount (₹)</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Offering "Thal" to Mataji (One time)</td>
                                <td class="amt">₹ 551/-</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Offering "Thal" to Mataji (Two times)</td>
                                <td class="amt">₹ 1,100/-</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Offering "Thal" to Mataji (For one month)</td>
                                <td class="amt">₹ 21,000/-</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Oil for "Akhand Jyot" (For one day)</td>
                                <td class="amt">₹ 551/-</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Oil for "Akhand Jyot" (For one month)</td>
                                <td class="amt">₹ 11,000/-</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Oil for "Akhand Jyot" (For one year)</td>
                                <td class="amt">₹ 51,000/-</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Cooking/Kitchen Seva (One time)</td>
                                <td class="amt">₹ 5,100/-</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Cooking/Kitchen Seva (For one day)</td>
                                <td class="amt">₹ 11,000/-</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Cooking/Kitchen Seva (For one month)</td>
                                <td class="amt">₹ 1,51,000/-</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Hoisting the Flag (Dhaja) for Dada</td>
                                <td class="amt">₹ 2,500/-</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Hoisting the Flag (Dhaja) for Mataji</td>
                                <td class="amt">₹ 3,000/-</td>
                            </tr>

                            <!-- Important Instructions -->
                            <tr class="important-title">
                                <td colspan="3">Important Instructions</td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>The flag (Dhaja) must be obtained from the temple's office.</td>
                                <td class="amt">-</td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>To hoist the flag, an offering of "Thal" to Mataji is mandatory.</td>
                                <td class="amt">-</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>Registration is required to hoist the flag. Mobile: 97236 82345</td>
                                <td class="amt">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="donation-box">
                    <div class="donation-head">Donation send to...</div>
                    <div class="donation-box-body">
                        <h4>
                            Donations are accepted by Cheque/Cash in favour of DIVYADHAM MANDIR TRUST - VALARDI to all
                            the branches of following bank. Details are given below.
                        </h4>
                        <div class="bank-info">
                            <p><strong>Bank Name:</strong>ICICI BANK</p>
                            <p><strong>ICICI BANK:</strong>170805021740</p>
                            <p><strong>IFSC:</strong>ICICI0001708</p>
                            <p><strong>Reg. No.:</strong>IN-DL50261537179183T</p>
                            <p><strong>PAN:</strong>AAQTS144J</p>
                        </div>
                    </div>
                    <div class="donation-footer">
                        <p>Donations made to this organization are fully tax-exempt under Section 80G (5) of the Income
                            Tax Act, 1961.
                        </p>
                    </div>
                </div>
            </div>
            <div class="donation-image">
                <img src="{{ asset('images/divine_side.png') }}" alt="Temple">
                <img src="{{ asset('images/divine_side.png') }}" alt="Temple">
            </div>
        </div>
    </section>
    <!-- Footer -->
    @include('components.footer')

    <script src="{{ asset('js/header.js') }}"></script>
</body>

</html>

