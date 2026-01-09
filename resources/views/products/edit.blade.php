<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Product</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        min-height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .container {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        width: 400px;
        max-width: 100%;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        position: relative;
        overflow: hidden;
    }

    .container::before {
        content: "";
        position: absolute;
        top: -40%;
        left: -40%;
        width: 180%;
        height: 180%;
        background: radial-gradient(circle at 30% 30%, #42a5f5, transparent 40%);
        opacity: 0.15;
        animation: rotateGrad 8s linear infinite;
        border-radius: 50%;
        pointer-events: none;
    }

    @keyframes rotateGrad {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .error-list {
        padding: 10px 15px;
        background: #f8d7da;
        color: #842029;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .error-list ul {
        padding-left: 20px;
        margin: 0;
    }

    label {
        display: block;
        margin-bottom: 6px;
        color: #555;
        font-weight: bold;
    }

    input[type="text"] {
        width: 93%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 10px;
        margin-bottom: 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    input[type="text"]:focus {
        border-color: #1976d2;
        box-shadow: 0 0 10px rgba(25, 118, 210, 0.3);
        outline: none;
    }

    select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 10px;
        margin-bottom: 15px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #fff;
    }

    select:focus {
        border-color: #1976d2;
        box-shadow: 0 0 10px rgba(25,118,210,0.3);
        outline: none;
    }

    input[type="submit"] {
        width: 100%;
        background: linear-gradient(135deg, #1976d2, #42a5f5);
        border: none;
        color: white;
        padding: 12px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    input[type="submit"]:disabled {
        background: #ccc;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    input[type="submit"]:hover:enabled {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    .return-btn {
        text-align: center;
        margin-top: 20px;
    }

    .return-btn a {
        display: inline-block;
        background: #ff9800;
        color: #fff;
        padding: 10px 16px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .return-btn a:hover {
        background: #fb8c00;
        transform: scale(1.05);
    }
</style>
</head>
<body>
<div class="container">
    <h1>Edit Record</h1>

    @if($errors->any())
        <div class="error-list">
            <strong>Whoops! Something went wrong:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('product.update', ['product' => $product]) }}" id="editForm">
        @csrf
        @method('put')

        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ $product->name }}" />
        </div>
        <div>
            <label>Lastname</label>
            <input type="text" name="qty" value="{{ $product->qty }}" />
        </div>
        <div>
            <label>Age</label>
            <input type="text" name="price" value="{{ $product->price }}" />
        </div>
        <div>
            <label>Address</label>
            <select name="description">
                <option value="" disabled {{ $product->description ? '' : 'selected' }}>Select Purok</option>
                <option value="Purok I" {{ $product->description == 'Purok I' ? 'selected' : '' }}>Purok I</option>
                <option value="Purok II" {{ $product->description == 'Purok II' ? 'selected' : '' }}>Purok II</option>
                <option value="Purok III" {{ $product->description == 'Purok III' ? 'selected' : '' }}>Purok III</option>
                <option value="Purok IV" {{ $product->description == 'Purok IV' ? 'selected' : '' }}>Purok IV</option>
                <option value="Purok V" {{ $product->description == 'Purok V' ? 'selected' : '' }}>Purok V</option>
            </select>
        </div>
        
        <div>
            <label>Contact Number</label>
            <input type="text" name="contact_number" value="{{ $product->contact_number ?? '' }}" placeholder="Contact Number" />
        </div>
        <div>
            <input type="submit" value="Update Record" id="updateBtn" disabled />
        </div>
    </form>

    <div class="return-btn">
        <a href="{{ route('product.index') }}">← Return to Product List</a>
    </div>
</div>

<script>
    const form = document.getElementById('editForm');
    const inputs = form.querySelectorAll('input[type="text"]');
    const submitBtn = document.getElementById('updateBtn');

    // Store initial values
    const originalValues = {};
    inputs.forEach(input => {
        originalValues[input.name] = input.value;
    });

    function checkForChanges() {
        let changed = false;
        inputs.forEach(input => {
            if (input.value.trim() !== originalValues[input.name].trim()) {
                changed = true;
            }
        });
        submitBtn.disabled = !changed;
    }

    inputs.forEach(input => {
        input.addEventListener('input', checkForChanges);
    });
</script>
</body>
</html>


