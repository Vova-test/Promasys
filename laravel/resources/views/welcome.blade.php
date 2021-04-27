<form method="POST" action="/foo" >
    {{ csrf_field() }}
    <input type="text" name="name"/><br/>
    <input type="submit" value="Add"/>
</form>
