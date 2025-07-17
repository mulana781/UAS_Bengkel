# Dokumentasi Bengkel Management System

## 📋 Penjelasan Ringkas Proyek

Bengkel Management System adalah aplikasi web berbasis Laravel yang menyediakan sistem manajemen lengkap untuk bengkel otomotif. Aplikasi ini mencakup fitur autentikasi multi-level, operasi CRUD untuk berbagai entitas, dan dashboard interaktif dengan visualisasi data.

## 📁 Struktur Folder Proyek

```
bengkel-management/
├── app/
│   ├── Http/
│   │   ├── Controllers/           # Controller untuk semua fitur
│   │   │   ├── AuthController.php      # Handle login, register, logout
│   │   │   ├── CustomerController.php  # CRUD Customer
│   │   │   ├── VehicleController.php   # CRUD Vehicle  
│   │   │   ├── ServiceController.php   # CRUD Service
│   │   │   ├── ServiceNoteController.php # CRUD ServiceNote
│   │   │   └── DashboardController.php # Dashboard & statistik
│   │   └── Middleware/
│   │       └── CheckRole.php          # Middleware untuk role-based access
│   └── Models/                    # Model Eloquent
│       ├── User.php               # User dengan role relationship
│       ├── Role.php               # Role model dengan permission
│       ├── Customer.php           # Customer model
│       ├── Vehicle.php            # Vehicle model
│       ├── Service.php            # Service model
│       └── ServiceNote.php        # ServiceNote model
├── database/
│   ├── migrations/                # Database migrations
│   │   ├── create_roles_table.php
│   │   ├── add_role_id_to_users_table.php
│   │   ├── create_customers_table.php
│   │   ├── create_vehicles_table.php
│   │   ├── create_services_table.php
│   │   └── create_service_notes_table.php
│   └── seeders/
│       └── RoleSeeder.php        # Seeder untuk roles & default users
├── resources/
│   └── views/
│       ├── auth/                  # Halaman autentikasi
│       │   ├── login.blade.php    # Form login
│       │   └── register.blade.php # Form register
│       ├── layouts/
│       │   └── app.blade.php     # Layout utama dengan navbar
│       ├── dashboard.blade.php    # Dashboard dengan charts
│       ├── customers/             # Views CRUD Customer
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── vehicles/              # Views CRUD Vehicle
│       ├── services/              # Views CRUD Service
│       └── service-notes/         # Views CRUD ServiceNote
├── routes/
│   └── web.php                   # Route definitions dengan middleware
└── public/                       # Assets (CSS, JS, images)
```

## 🔐 Alur Login hingga Dashboard

### 1. Akses Aplikasi
- User mengakses `http://localhost:800- Middleware `auth` mengecek status login user
- Jika belum login → redirect ke `/login`

### 2laman Login
- User melihat form login dengan design modern
- Form berisi field email dan password
- Validasi client-side dan server-side diterapkan

### 3Proses Autentikasi
- User submit form login
- `AuthController@login` memproses request
- Validasi credentials menggunakan Laravel Auth
- Jika berhasil → regenerate session dan redirect ke dashboard
- Jika gagal → kembali ke form dengan error message

### 4. Dashboard sesuai Role
- **Admin**: Akses penuh ke semua menu
- **Manager**: Akses ke customer, vehicle, service, service-notes
- **Staff**: Akses ke service dan service-notes
- **Customer**: Hanya dashboard dan profil

### 5. Session Management
- Session disimpan dengan aman
- CSRF protection pada semua form
- Logout menghapus session dan regenerate token

## 🗄️ Alur CRUD: Customer Management

### Create (Tambah Data)
1**Akses Halaman**
   - User login dengan role yang memiliki permission
   - Klik menu "Customers di navbar
   - Klik tombolAdd Customerdi halaman index

2 **Form Input**
   - Form create customer muncul
   - Field: name, phone, address, email
   - Validasi real-time dan server-side3**Proses Penyimpanan**
   ```php
   // CustomerController@store
   $request->validate(name' =>required|string|max:255
 phone' =>required|string|max:20,
   address' => 'required|string',
 email' => 'required|email|unique:customers,email',
   ]);
   
   Customer::create($request->all());
   return redirect()->route('customers.index)   ->with('success',Customer created successfully!');
   ```

4 **Feedback**
   - Redirect ke halaman index
   - Success message ditampilkan
   - Data baru muncul di tabel

### Read (Lihat Data)
1**Halaman Index**
   - Tabel menampilkan semua customer
   - Pagination untuk data besar
   - Search dan filter functionality

2. **Halaman Detail**
   - Klik tombolViewpada baris data
   - Menampilkan detail customer lengkap
   - Relasi dengan vehicles dan services

### Update (Edit Data)
1. **Akses Form Edit**
   - Klik tombolEditpada baris data
   - Form edit muncul dengan data yang sudah ada

2**Proses Update**
   ```php
   // CustomerController@update
   $request->validate(name' =>required|string|max:255
 phone' =>required|string|max:20,
   address' => 'required|string',
 email' => 'required|email|unique:customers,email,' . $customer->id,
   ]);
   
   $customer->update($request->all());
   return redirect()->route('customers.index)   ->with('success',Customer updated successfully!');
   ```

3 **Feedback**
   - Redirect ke halaman index
   - Success message ditampilkan
   - Data terupdate di tabel

### Delete (Hapus Data)
1. **Konfirmasi Delete**
   - Klik tombolDeletepada baris data
   - Konfirmasi dialog muncul
   - User konfirmasi untuk menghapus

2**Proses Delete**
   ```php
   // CustomerController@destroy
   $customer->delete();
   return redirect()->route('customers.index)   ->with('success',Customer deleted successfully!');
   ```

3 **Feedback**
   - Redirect ke halaman index
   - Success message ditampilkan
   - Data terhapus dari tabel

## 🛡️ Validasi Form

### Server-side Validation
Semua form menggunakan validasi Laravel:

```php
// Contoh validasi Customer
$request->validate([
    'name' =>required|string|max:255,
    'phone' =>required|string|max:20,
address' => 'required|string',
    'email' => 'required|email|unique:customers,email,' . $customer->id,
]);

// Contoh validasi Service
$request->validate(  vehicle_id' =>required|exists:vehicles,id,
    date' =>required|date,  kilometer' => required|integer|min:0',
    description' => 'required|string,status' => 'required|in:pending,in_progress,completed',
]);
```

### Error Handling
- Error ditampilkan di bawah field yang bermasalah
- Old input dipertahankan untuk user experience
- Custom error messages untuk bahasa Indonesia

## 🔒 Middleware dan Security

### Authentication Middleware
```php
// routes/web.php
Route::middleware(['auth'])->group(function () {
    // Protected routes
});
```

### Role-based Access Control
```php
// Middleware CheckRole
Route::middleware(['role:admin,manager,staff'])->group(function () {
    Route::resource('customers', CustomerController::class);
});
```

### CSRF Protection
- Semua form menggunakan `@csrf` directive
- CSRF token otomatis di-generate Laravel
- Protection terhadap CSRF attacks

## 📊 Dashboard Features

### Statistik Real-time
- Total Services: Menghitung semua layanan
- Total Revenue: Menghitung total pendapatan dari service notes
- Total Vehicles: Menghitung semua kendaraan
- Active Services: Menghitung layanan yang sedang berlangsung

### Charts Interaktif
- Line Chart: Trend layanan per bulan
- Bar Chart: Jumlah layanan per bulan
- Pie Charts: Status completion percentage

### Progress Bars
- Service Status: Progress layanan yang sedang berlangsung
- Revenue Status: Progress target pendapatan

## 🎨 UI/UX Features

### Responsive Design
- Bootstrap 5 untuk layout responsive
- Custom CSS untuk styling modern
- Mobile-first approach

### Modern Interface
- Gradient backgrounds
- Card-based design
- Font Awesome icons
- Smooth animations

### User Experience
- Intuitive navigation
- Clear feedback messages
- Loading states
- Form validation real-time

## 🚀 Deployment

### Requirements
- PHP >= 7.4MySQL >= 5.7poser
- Web server (Apache/Nginx)

### Environment Setup
1. Clone repository
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env`
4. Generate app key: `php artisan key:generate`
5. Configure database in `.env`
6 Run migrations: `php artisan migrate`7. Seed database: `php artisan db:seed --class=RoleSeeder`
8Start server: `php artisan serve`

**maaf pak tidak tau caranya menambahkan gambar pada readme di github jadi tidak saya upload**
