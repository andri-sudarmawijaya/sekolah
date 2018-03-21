<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Edit Prodi Sekolah

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <vue-form class="form-horizontal form-validation" :state="state" @submit.prevent="onSubmit">
        <div class="form-row">
          <div class="col-md">
            <validate tag="div">
              <label for="keterangan">Keterangan</label>
              <input class="form-control" v-model="model.keterangan" required autofocus name="keterangan" type="text" placeholder="keterangan">

              <field-messages name="keterangan" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Keterangan is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="kuota_siswa">Kuota Siswa</label>
              <input class="form-control" v-model="model.kuota_siswa" name="kuota_siswa" type="text" placeholder="kuota_siswa">

              <field-messages name="kuota_siswa" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="user_id">Username</label>
            <v-select name="user_id" v-model="model.user" :options="user" class="mb-4"></v-select>

            <field-messages name="user_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Username is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="sekolah">Sekolah</label>
            <v-select name="sekolah" v-model="model.sekolah" :options="sekolah" class="mb-4"></v-select>

            <field-messages name="sekolah" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Sekolah is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">            
            <button type="submit" class="btn btn-primary">Submit</button>

            <button type="reset" class="btn btn-secondary" @click="reset">Reset</button>            
          </div>
        </div>
        
      </vue-form>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    axios.get('api/prodi-sekolah/' + this.$route.params.id + '/edit')
      .then(response => {
        if (response.data.status == true) {

          this.model.keterangan     = response.data.sekolah.keterangan;
          this.model.kuota_siswa    = response.data.sekolah.kuota_siswa;
          this.model.old_user_id    = response.data.sekolah.user_id;
          this.model.user           = response.data.user;
          this.model.old_user       = response.data.sekolah.user;
          this.model.sekolah        = response.data.sekolah.sekolah;
          

        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break1');
        window.location.href = '#/admin/prodi-sekolah';
      });

      axios.get('api/prodi-sekolah/create')
      .then(response => {           
          response.data.user.forEach(element => {
            this.user.push(element);
          });
          response.data.sekolah.forEach(element => {
            this.sekolah.push(element);
          });
      })
      .catch(function(response) {
        alert('Break');
      })
  },
  data() {
    return {
      state: {},
      model: {
        keterangan:          "",
        kuota_siswa:         "",
        user:                "",
        sekolah:             "",
        
      },
      user: [],
      sekolah: []
    }
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.put('api/prodi-sekolah/' + this.$route.params.id, {
            user_id:            this.model.user.id,
            old_user_id:        this.model.old_user_id,
            sekolah_id:         this.model.sekolah.id,
            keterangan:         this.model.keterangan,
            kuota_siswa:        this.model.kuota_siswa,
          })
          .then(response => {
            if (response.data.status == true) {
              if(response.data.message == 'success'){
                alert(response.data.message);
                app.back();
              }else{
                alert(response.data.message);
              }
            } else {
              alert(response.data.message);
            }
          })
          .catch(function(response) {
            alert('Break ' + response.data.message);
          });
      }
    },
    reset() {
      axios.get('api/prodi-sekolah/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.user           = response.data.sekolah.user;
            this.model.sekolah        = response.data.sekolah.sekolah;
            this.model.keterangan     = response.data.sekolah.keterangan;
            this.model.kuota_siswa    = response.data.sekolah.kuota_siswa;
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break ');
        });
    },
    back() {
      window.location = '#/admin/prodi-sekolah';
    }
  }
}
</script>
