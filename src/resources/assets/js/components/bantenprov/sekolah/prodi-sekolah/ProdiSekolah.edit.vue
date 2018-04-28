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
       <!--  <div class="form-row">
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
       </div> -->

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
            <validate tag="div">
            <label for="program_keahlian_id">Program Keahlian</label>
            <v-select name="program_keahlian_id" v-model="model.program_keahlian" :options="program_keahlian" class="mb-4"></v-select>

            <field-messages name="program_keahlian_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">program keahlian is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="kuota_siswa">Kuota Siswa</label>
              <input class="form-control" v-model="model.kuota_siswa" name="kuota_siswa" type="text" placeholder="Kuota Siswa">

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
            <button type="submit" class="btn btn-primary">Submit</button>

            <button type="reset" class="btn btn-secondary" @click="reset">Reset</button>
          </div>
        </div>

      </vue-form>
    </div>
  </div>
</template>

<script>

import swal from 'sweetalert2';

export default {
  mounted() {
    axios.get('api/prodi-sekolah/' + this.$route.params.id + '/edit')
      .then(response => {
        if (response.data.status == true) {

          this.model.kuota_siswa      = response.data.prodi_sekolah.kuota_siswa;
          this.model.old_user_id      = response.data.prodi_sekolah.user_id;
          this.model.user             = response.data.prodi_sekolah.user.name;
          this.model.program_keahlian = response.data.prodi_sekolah.program_keahlian;
          /*this.model.old_user         = response.data.prodi_sekolah.sekolah.user;*/
          this.model.sekolah          = response.data.prodi_sekolah.sekolah;



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
        if (response.data.status == true && response.data.error == false) {
          this.sekolah              = response.data.sekolahs;
          this.program_keahlian     = response.data.program_keahlians;
          this.model.user           = response.data.current_user;

          if(response.data.user_special == true){
            this.user = response.data.users;
          }else{
            this.user.push(response.data.users);
          }
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error'
          );

          app.back();
        }
      })
      axios.get('api/sekolah/get')
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.sekolah = response.data.sekolahs;
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error'
          );

          app.back();
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error'
        );

        app.back();
      });
  },
  data() {
    return {
      state: {},
      model: {
        kuota_siswa:         "",
        user:                "",
        sekolah:             "",
        program_keahlian:    "",

        user_id           : "",
        created_at        : "",
        updated_at        : "",
        sekolah_id        : "",


      },
      user: [],
      sekolah: [],
      program_keahlian: []
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
            program_keahlian_id:this.model.program_keahlian.id,
            kuota_siswa:        this.model.kuota_siswa,
          })
          .then(response => {
            if (response.data.status == true) {
              if(response.data.error == false){
                swal(
                  'Updated',
                  'Yeah!!! Your data has been updated.',
                  'success'
                );

                app.back();
              }else{
                swal(
                  'Failed',
                  'Oops... '+response.data.message,
                  'error'
                );
              }
            } else {
              swal(
                'Failed',
                'Oops... '+response.data.message,
                'error'
              );

              app.back();
            }
          })
          .catch(function(response) {
            swal(
              'Not Found',
              'Oops... Your page is not found.',
              'error'
            );

            app.back();
          });
      }
    },
    reset() {
      axios.get('api/prodi-sekolah/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.user             = response.data.prodi_sekolah.user.name;
            this.model.sekolah          = response.data.prodi_sekolah.sekolah;
            this.model.program_keahlian = response.data.prodi_sekolah.program_keahlian;
            this.model.kuota_siswa      = response.data.prodi_sekolah.kuota_siswa;
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