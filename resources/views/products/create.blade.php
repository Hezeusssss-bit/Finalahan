<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Create Resident</title>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f5f5; min-height: 100vh; display: flex; }

.sidebar { width: 250px; background: #1a1a2e; min-height: 100vh; padding: 30px 0; position: fixed; left: 0; top: 0; display: flex; flex-direction: column; }
.logo { color: #fff; font-size: 24px; font-weight: 700; padding: 0 30px; margin-bottom: 50px; display: flex; align-items: center; gap: 10px; }
.nav-menu { flex: 1; }
.nav-item { color: #999; padding: 15px 30px; text-decoration: none; display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 15px; transition: all 0.3s ease; }
.nav-item i { width: 20px; text-align: center; }
.nav-item.active { color: #fff; background: rgba(255,255,255,0.1); border-left: 3px solid #fff; }

.main-content { margin-left: 250px; flex: 1; padding: 30px 40px; }

.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
.header h1 { color: #1a1a2e; font-size: 28px; font-weight: 700; }
.header-icons { display: flex; gap: 15px; align-items: center; }
.icon-btn { width: 40px; height: 40px; border-radius: 50%; background: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.icon-btn i { color: #333; font-size: 16px; }

.container { background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); position: relative; overflow: hidden; max-width: 600px; margin: auto; }

.container::before { content: ""; position: absolute; top: -40%; left: -40%; width: 180%; height: 180%; background: radial-gradient(circle at 30% 30%, #42a5f5, transparent 40%); opacity: 0.15; animation: rotateGrad 8s linear infinite; border-radius: 50%; pointer-events: none; }

@keyframes rotateGrad { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

label { display: block; margin-bottom: 6px; color: #555; font-weight: bold; }
input[type="text"] { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 10px; margin-bottom: 5px; font-size: 14px; transition: all 0.3s ease; }
input[type="text"]:focus { border-color: #1976d2; box-shadow: 0 0 10px rgba(25,118,210,0.3); outline: none; }
select { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 10px; margin-bottom: 5px; font-size: 14px; transition: all 0.3s ease; background: #fff; }
select:focus { border-color: #1976d2; box-shadow: 0 0 10px rgba(25,118,210,0.3); outline: none; }
.error-message { color: #842029; font-size: 12px; margin-bottom: 10px; }

.btn-add { padding: 10px 20px; border-radius: 8px; background: #fff; border: 1px solid #ddd; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; color: #333; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; }
.btn-add:hover { background: #1a1a2e; color: #fff; border-color: #1a1a2e; }

.btn-export { padding: 10px 20px; border-radius: 8px; background: #1a1a2e; border: none; color: #fff; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; }
.btn-export:hover { background: #0f0f1e; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(26,26,46,0.3); }

.filter-section { display: flex; flex-direction: column; gap: 15px; }

.return-btn { margin-top: 20px; }
.return-btn a { text-decoration: none; color: #1a1a2e; font-weight: 600; }
.return-btn a:hover { text-decoration: underline; }

.alert { position: fixed; top: 20px; right: 20px; background-color: #17002B; color: #ffffff; padding: 15px 25px; border-radius: 10px; font-weight: 600; box-shadow: 0 4px 15px #17002B; z-index: 9999; opacity: 0; animation: slideIn 0.5s forwards; }
.alert.success { background-color: #17002B; color: #fff; }
@keyframes slideIn { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
@keyframes slideOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100px); } }
.alert.hide { animation: slideOut 0.5s forwards; }

</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div class="logo">
    <i class="fas fa-store"></i>
    <span>Logo</span>
  </div>
  <nav class="nav-menu">
    <a href="{{ route('resident.index') }}" class="nav-item"><i class="fas fa-home"></i> <span>Dashbaord</span></a>
    <a href="{{ url('/home') }}" class="nav-item "><i class="fas fa-boxes"></i> <span>Residents</span></a>
  </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Header -->
    <div class="header">
        <h1>Create Resident</h1>
        <div class="header-icons">
            <button class="icon-btn"><i class="fas fa-bell"></i></button>
            <button class="icon-btn"><i class="fas fa-user"></i></button>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('Success'))
        <div class="alert success" id="successAlert">{{ session('Success') }}</div>
    @endif

    <!-- Form Container -->
    <div class="container">
        <form method="POST" action="{{ route('resident.store') }}">
            @csrf
            <div class="filter-section">
                <div>
                    <label>Name</label>
                    <input type="text" name="name" placeholder="First name" value="{{ old('name') }}" />
                    @error('name')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label>Lastname</label>
                    <input type="text" name="qty" placeholder="Lastname" value="{{ old('qty') }}" />
                    @error('qty')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label>Age</label>
                    <input type="text" name="price" placeholder="Age" value="{{ old('price') }}" />
                    @error('price')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label>Gender</label>
                    <select name="gender">
                        <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label>Address</label>
                    <select name="description">
                        <option value="" disabled {{ old('description') ? '' : 'selected' }}>Select Purok</option>
                        <option value="Purok I" {{ old('description') == 'Purok I' ? 'selected' : '' }}>Purok I</option>
                        <option value="Purok II" {{ old('description') == 'Purok II' ? 'selected' : '' }}>Purok II</option>
                        <option value="Purok III" {{ old('description') == 'Purok III' ? 'selected' : '' }}>Purok III</option>
                        <option value="Purok IV" {{ old('description') == 'Purok IV' ? 'selected' : '' }}>Purok IV</option>
                        <option value="Purok V" {{ old('description') == 'Purok V' ? 'selected' : '' }}>Purok V</option>
                    </select>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <input type="submit" value="Save New Resident" class="btn-add"/>
                </div>
            </div>
        </form>

        <div class="return-btn">
            <a href="{{ route('resident.index') }}">← Return to Resident List</a>
        </div>
    </div>
</div>

<!-- Floating Alerts Script -->
<script>
setTimeout(() => {
    const alert = document.getElementById('successAlert');
    if (alert) {
        alert.classList.add('hide');
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);
</script>

</body>
</html>
