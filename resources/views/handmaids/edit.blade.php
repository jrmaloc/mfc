<x-edit-form
    :section="$handmaids"
    :id="$id"
    changePassRoute="{{ route('handmaids.updatePassword', ['handmaid' => $id]) }}"
    updateRoute="{{ route('handmaids.update', ['handmaid' => $id]) }}"
     :role="$role"
     :tithes="$tithes"
     :events="$events"
     :age="$age">

</x-edit-form>
