<template>
    <div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Nama</label>
            <div class="col">
                <input type="text" class="form-control" placeholder="Masukkan nama user" name="user[nama]" value="">

                <!-- @error('nama') -->
                    <small class="text-danger">Error</small>
                <!-- @enderror   -->

            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Email</label>
            <div class="col">
                <input type="email" class="form-control" placeholder="Masukkan email" name="user[email]">

                <!-- @error('email') -->
                    <small class="text-danger">Error</small>
                <!-- @enderror   -->

            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Username</label>
            <div class="col">
                <input type="text" class="form-control" placeholder="Masukkan username" name="user[username]">

            

            </div>
        </div>
        
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Password</label>
            <div class="col">
                <input type="password" class="form-control" placeholder="Password" name="user[password]">

                <!-- @error('password') -->
                     <small class="text-danger">Error</small>
                <!-- @enderror   -->

            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label required">Peran</label>
            <div class="col">
                <div>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role[name]" value="2">
                        <span class="form-check-label">Administrator</span>
                    </label>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role[name]" value="3">
                        <span class="form-check-label">Teacher</span>
                    </label>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role[name]" value="4" checked>
                        <span class="form-check-label">Peserta</span>
                    </label>
                </div>

                <!-- @error('role') -->
                    <small class="text-danger">Error</small>
                <!-- @enderror   -->
                    
            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label">Jenis Kelamin</label>

            <div class="col">
        
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user[gender]" value="1">
                    <span class="form-check-label">Laki-laki</span>
                </label>
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user[gender]" value="2">
                    <span class="form-check-label">Perempuan</span>
                </label>
                    
            </div>
        </div>
        
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label">Tanggal Lahir</label>
            <div class="col">
                <input type="date" class="form-control" name="user[tanggal_lahir]" id="tanggal_lahir" value="">

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'user-add-new-form'
}
</script>