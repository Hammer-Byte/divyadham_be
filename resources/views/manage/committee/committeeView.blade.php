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
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-committee-members" aria-controls="navs-pills-committee-members" aria-selected="true">Committee Members</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-committee-meetings" aria-controls="navs-pills-committee-meetings" aria-selected="false" tabindex="-1">Committee Meetings</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-committee-finance" aria-controls="navs-pills-committee-finance" aria-selected="false" tabindex="-1">Committee Finance</button>
                      </li>
                    </ul>
                  </div>
                  <div class="tab-content shadow-none p-0">
                    <div class="tab-pane fade show active" id="navs-pills-committee-members" role="tabpanel">
                        @include('manage.committee.committeeMember.committeeMembers')
                    </div>
                    <div class="tab-pane fade" id="navs-pills-committee-meetings" role="tabpanel">
                        @include('manage.committee.committeeMeeting.committeeMeetings')
                    </div>
                    <div class="tab-pane fade" id="navs-pills-committee-finance" role="tabpanel">
                        @include('manage.committee.committeeFinance.committeeFinance')
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
          committeeMembersTable()
        }else{
            var targetTab = '#'+currentTab;
            tabChangeEvents(targetTab)
        }

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var targetTab = $(e.target).attr("data-bs-target");
            tabChangeEvents(targetTab)
        });

        function tabChangeEvents(targetTab) {
            if (targetTab == "#navs-pills-committee-members") {
                committeeMembersTable()
            }
            if (targetTab == "#navs-pills-committee-meetings") {
                committeeMeetingsTable()
            }
            if (targetTab == "#navs-pills-committee-finance") {
                committeeFinanceTable()
            }
        }
    });
</script>
@append
