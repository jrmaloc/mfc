<x-edit-form
    :section="$user"
    :id="$id"
    changePassRoute="{{ route('profile.updatePassword', ['user' => $user]) }}"
    updateRoute="{{ route('profile.update', ['user' => $user]) }}"
     :role="$role"
     :tithes="$tithes"
     :events="$events"
     :age="$age">

</x-edit-form>

<script>
    $(document).ready(function() {
        $('#verifyEmail').prop('disabled', true);
    });
</script>
