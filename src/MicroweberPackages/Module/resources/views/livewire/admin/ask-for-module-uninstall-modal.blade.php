<div>
    @if(isset($moduleData['name']))



    <form wire:submit.prevent="confirm">
        <div class="modal-header bg-light border-0">
            <h5 class="modal-title">
                {{_e('Uninstall')}} {{$moduleData['name']}}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="$emit('closeModal')"></button>

        </div>
        <div class="modal-body">
                {{_e('Are you sure you want to uninstall')}} {{$moduleData['name']}} ?
        </div>
        <div class="modal-footer bg-light border-0 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close" wire:click="$emit('closeModal')">
                {{_e('Cancel')}}
            </button>

            <button type="submit" class="btn btn-danger">
                {{_e('Uninstall')}}
            </button>

        </div>
    </form>

    @else
        <div class="alert alert-danger">{{_e('Please select a module')}}</div>
     @endif

</div>