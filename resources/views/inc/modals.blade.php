
<div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang("Confirmation Notice")!</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Campaigns Modal --}}
<div class="modal fade"  id="campaignPreviewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom " id="modal-size" role="document">
        <div class="modal-content position-relative" id="modal-content">
            <div id="campaign-previw-details-body">

            </div>
        </div>
    </div>

</div>
