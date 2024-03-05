<x-edit-form
    :section="$singles"
    :id="$id"
    changePassRoute="{{ route('singles.updatePassword', ['single' => $id]) }}"
    updateRoute="{{ route('singles.update', ['single' => $id]) }}"
     :role="$role"
     :tithes="$tithes"
     :events="$events"
     :age="$age">

</x-edit-form>
