<h2>تعديل مستخدم: {{ $user->name }}</h2>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">الاسم</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
    </div>

    <div class="mb-3">
        <label class="form-label">البريد الإلكتروني</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
    </div>

    <div class="mb-3">
        <label class="form-label">الدور / الصلاحية</label>
        <select name="role" class="form-control">
            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>مستخدم</option>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>أدمن</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">تحديث المستخدم</button>
    <a href="{{ route('dashboard.index', ['section' => 'users']) }}" class="btn btn-secondary">عودة للمستخدمين</a>
</form>
