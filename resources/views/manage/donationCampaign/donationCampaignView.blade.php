@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.alerts')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <div class="row m-4">
            <div class="col-xl-12">
                <div class="nav-align-top mb-6">
                  <div class="border-bottom border-bottom-1 border-primary">
                    <ul class="nav nav-pills mb-2" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-donation-media" aria-controls="navs-pills-donation-media" aria-selected="true" tabindex="-1">Donation Media</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-donation-updates" aria-controls="navs-pills-donation-updates" aria-selected="true" tabindex="-1">Donation Updates</button>
                      </li>
                    </ul>
                  </div>
                  <div class="tab-content shadow-none p-0">
                    <div class="tab-pane fade show active" id="navs-pills-donation-media" role="tabpanel">
                        @include('manage.donationCampaign.donationMedia.donationMedia')
                    </div>
                    <div class="tab-pane fade" id="navs-pills-donation-updates" role="tabpanel">
                        @include('manage.donationCampaign.donationUpdates.donationUpdates')
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraScript')
<script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var currentTab = urlParams.get('currentTab');

        if (!currentTab) {
            donationMediaTable()
        }else{
            var targetTab = '#'+currentTab;
            tabChangeDonations(targetTab)
        }

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var targetTab = $(e.target).attr("data-bs-target");
            tabChangeDonations(targetTab)
        });

        function tabChangeDonations(targetTab) {
            if (targetTab == "#navs-pills-donation-media") {
                donationMediaTable()
            }
            if (targetTab == "#navs-pills-donation-updates") {
                donationUpdatesTable()
            }
        }
    });
</script>
@append
