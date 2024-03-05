<x-edit-form :section="$kid" :id="$id" changePassRoute="{{ route('kids.updatePassword', ['kid' => $id]) }}" updateRoute="{{ route('kids.update', ['kid' => $id]) }}" :role="$role" :tithes="$tithes" :events="$events" :age="$age">

</x-edit-form>
