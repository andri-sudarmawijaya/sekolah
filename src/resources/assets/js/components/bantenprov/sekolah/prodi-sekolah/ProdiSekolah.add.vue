<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Add Prodi Sekolah

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
              <input class="form-control" v-model="model.Keterangan" required autofocus name="Keterangan" type="text" placeholder="Keterangan">

              <field-messages name="Keterangan" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <input class="form-control" v-model="model.kuota_siswa" required autofocus name="kuota_siswa" type="text" placeholder="Kuota Siswa">

              <field-messages name="kuota_siswa" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label is a required field</small>
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
              <small class="form-text text-danger" slot="required">Program Keahlian is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>


        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="sekolah_id">Sekolah</label>
            <v-select name="sekolah_id" v-model="model.sekolah" :options="sekolah" class="mb-4"></v-select>

            <field-messages name="sekolah_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Label is a required field</small>
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
              <small class="form-text text-danger" slot="required">Label is a required field</small>
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
  mounted(){
    axios.get('api/prodi-sekolah/create')
    .then(response => {
      if (response.data.status == true) {
        this.model.user = response.data.current_user;

        response.data.sekolah.forEach(element =>{
          this.sekolah.push(element);
        });
        response.data.program_keahlian.forEach(element =>{
          this.program_keahlian.push(element);
        });
        if(response.data.user_special == true){
          response.data.user.forEach(user_element => {
            this.user.push(user_element);
          });
        }else{
          this.user.push(response.data.user);
        }
      } else {
        alert('Failed');
      }
    })
    .catch(function(response) {
      alert('Break');
      window.location = '#/admin/prodi-sekolah';
    });
  },
  data() {
    return {
      state: {},
      model: {
        Keterangan: "",
        kuota_siswa: "",
        sekolah: "",
        user: "",
        program_keahlian: "",

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
        axios.post('api/prodi-sekolah', {
            keterangan:           this.model.Keterangan,
            kuota_siswa:          this.model.kuota_siswa,
            sekolah_id:           this.model.sekolah.id,
            program_keahlian_id:  this.model.program_keahlian.id,
            user_id:              this.model.user.id
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
      this.model = {
          Keterangan: "",
          kuota_siswa: "",
          program_keahlian: "",
          sekolah: "",
          user: ""
      };
    },
    back() {
      window.location = '#/admin/prodi-sekolah';
    }
  }
}
</script>