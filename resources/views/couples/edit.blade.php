<x-edit-form
    :section="$couplese"
    :id="$id"
    changePassRoute="{{ route('couplese.updatePassword', ['couple' => $id]) }}"
    updateRoute="{{ route('couplese.update', ['couple' => $id]) }}"
     :role="$role"
     :tithes="$tithes"
     :events="$events"
     :age="$age">

</x-edit-form>
