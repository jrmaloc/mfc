<x-edit-form
    :section="$youth"
    :id="$id"
    changePassRoute="{{ route('youth.updatePassword', ['youth' => $id]) }}"
    updateRoute="{{ route('youth.update', ['youth' => $id]) }}"
     :role="$role"
     :tithes="$tithes"
     :events="$events"
     :age="$age">

</x-edit-form>
