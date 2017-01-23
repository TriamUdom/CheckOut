<form action="/logout" method="POST">
    {{ csrf_field() }}
    <input type="submit" value="Logout">
</form>
