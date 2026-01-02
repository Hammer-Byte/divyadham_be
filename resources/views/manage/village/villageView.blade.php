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
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-village-members" aria-controls="navs-pills-village-members" aria-selected="true">Village Members</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-village-media" aria-controls="navs-pills-village-media" aria-selected="false" tabindex="-1">Village Media</button>
                      </li>
                    </ul>
                  </div>
                  <div class="tab-content shadow-none p-0">
                    <div class="tab-pane fade show active" id="navs-pills-village-members" role="tabpanel">
                        @include('manage.village.villageMember.villageMembers')
                    </div>
                    <div class="tab-pane fade" id="navs-pills-village-media" role="tabpanel">
                        @include('manage.village.villageMedia.villageMedia')
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
            villageMembersTable()
        }else{
            var targetTab = '#'+currentTab;
            tabChangeEvents(targetTab)
        }

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var targetTab = $(e.target).attr("data-bs-target");
            tabChangeEvents(targetTab)
        });

        function tabChangeEvents(targetTab) {
            if (targetTab == "#navs-pills-village-members") {
                villageMembersTable()
            }
            if (targetTab == "#navs-pills-village-media") {
                villageMediaTable()
            }
        }
    });
</script>
@append
