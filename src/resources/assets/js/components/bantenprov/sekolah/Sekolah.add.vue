<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Add Sekolah

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
              <input class="form-control" v-model="model.label" required autofocus name="label" type="text" placeholder="Label">

              <field-messages name="label" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <input class="form-control" v-model="model.npsn" required autofocus name="npsn" type="text" placeholder="NPSN">

              <field-messages name="npsn" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <input class="form-control" v-model="model.alamat" required autofocus name="alamat" type="text" placeholder="Alamat">

              <field-messages name="alamat" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <input class="form-control" v-model="model.logo" required autofocus name="logo" type="text" placeholder="Logo">

              <field-messages name="logo" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <input class="form-control" v-model="model.foto_gedung" required autofocus name="foto_gedung" type="text" placeholder="Foto Gedung">

              <field-messages name="foto_gedung" show="$invalid && $submitted" class="text-danger">
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
            <validate tag="div">
            <label for="jenis_sekolah_id">Jenis Sekolah</label>
            <v-select name="jenis_sekolah" v-model="model.jenis_sekolah" :options="jenis_sekolah" class="mb-4"></v-select>

            <field-messages name="jenis_sekolah_id" show="$invalid && $submitted" class="text-danger">
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
    axios.get('api/sekolah/create')
    .then(response => {           
        response.data.user.forEach(element => {
          this.user.push(element);
        });

        response.data.jenis_sekolah.forEach(element =>{
          this.jenis_sekolah.push(element);
        });

    })
    .catch(function(response) {
      alert('Break');
    });
  },
  data() {
    return {
      state: {},
      model: {
        label: "",
        npsn: "",
        jenis_sekolah: "",
        alamat: "",
        logo: "",
        foto_gedung: "",
        user: ""

      },
      user: [],
      jenis_sekolah: []
    }
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.post('api/sekolah', {
            label:            this.model.label,
            jenis_sekolah_id: this.model.jenis_sekolah.id,
            npsn:             this.model.npsn,
            alamat:           this.model.alamat,
            logo:             this.model.logo,
            foto_gedung:      this.model.foto_gedung,
            user_id:          this.model.user.id
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
          label: "",
          jenis_sekolah: "",
          npsn: "",
          alamat: "",
          logo: "",
          foto_gedung: "",
          user: ""
      };
    },
    back() {
      window.location = '#/admin/sekolah';
    }
  }
}
</script>
