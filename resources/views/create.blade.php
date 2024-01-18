<form method="POST" action="{{ route('threads.store') }}">
    @csrf

    <label for="title">Title:</label>
    <input type="text" name="title" id="title">

    <label for="body">Content:</label>
    <textarea name="body" id="body" rows="4"></textarea>

    <label for="category">Category:</label>
    <select name="category_id" id="category">
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>


    <label for="rank">Rank:</label>
    <select name="rank" id="rank">
        <option value="Iron 1">Iron 1</option>
        <option value="Iron 2">Iron 2</option>
        <option value="Iron 3">Iron 3</option>
        <option value="Bronze 1">Bronze 1</option>
        <option value="Bronze 2">Bronze 2</option>
        <option value="Bronze 3">Bronze 3</option>
        <option value="Silver 1">Silver 1</option>
        <option value="Silver 2">Silver 2</option>
        <option value="Silver 3">Silver 3</option>
        <option value="Gold 1">Gold 1</option>
        <option value="Gold 2">Gold 2</option>
        <option value="Gold 3">Gold 3</option>
        <option value="Platinum 1">Platinum 1</option>
        <option value="Platinum 2">Platinum 2</option>
        <option value="Platinum 3">Platinum 3</option>
        <option value="Diamond 1">Diamond 1</option>
        <option value="Diamond 2">Diamond 2</option>
        <option value="Diamond 3">Diamond 3</option>
        <option value="Ascendant 1">Ascendant 1</option>
        <option value="Ascendant 2">Ascendant 2</option>
        <option value="Ascendant 3">Ascendant 3</option>
        <option value="Immortal 1">Immortal 1</option>
        <option value="Immortal 2">Immortal 2</option>
        <option value="Immortal 3">Immortal 3</option>
        <option value="Radiant">Radiant</option>
    </select>


    <button type="submit">Create Thread</button>
</form>