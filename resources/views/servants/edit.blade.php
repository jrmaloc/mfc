<x-edit-form
    :section="$servants"
    :id="$id"
    changePassRoute="{{ route('servants.updatePassword', ['servant' => $id]) }}"
    updateRoute="{{ route('servants.update', ['servant' => $id]) }}"
     :role="$role"
     :tithes="$tithes"
     :events="$events"
     :age="$age">

</x-edit-form>
