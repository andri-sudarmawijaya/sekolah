<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Edit Data Sekolah

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
              <label for="label">label</label>
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
              <label for="description">description</label>
              <input class="form-control" v-model="model.description" name="description" type="text" placeholder="Description">

              <field-messages name="description" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="npsn">NPSN</label>
              <input class="form-control" v-model="model.npsn" name="npsn" type="text" placeholder="NPSN">

              <field-messages name="npsn" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="alamat">Alamat</label>
              <input class="form-control" v-model="model.alamat" name="alamat" type="text" placeholder="Alamat">

              <field-messages name="alamat" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="logo">Logo</label>
              <input class="form-control" v-model="model.logo" name="logo" type="text" placeholder="logo">

              <field-messages name="logo" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="foto_gedung">Foto Gedung</label>
              <input class="form-control" v-model="model.foto_gedung" name="foto_gedung" type="text" placeholder="Foto Gedung">

              <field-messages name="foto_gedung" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="user">Username</label>
            <v-select name="user" v-model="model.user.name" :options="user" class="mb-4"></v-select>

            <field-messages name="user" show="$invalid && $submitted" class="text-danger">
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
  mounted() {
    axios.get('api/sekolah/' + this.$route.params.id + '/edit')
      .then(response => {
        if (response.data.status == true) {

          this.model.label       = response.data.sekolah.label;
          this.model.old_label   = response.data.sekolah.label;
          this.model.description = response.data.sekolah.description;
          this.model.user        = response.data.sekolah.user;
          this.model.npsn        = response.data.sekolah.npsn;
          this.model.alamat      = response.data.sekolah.alamat;
          this.model.logo        = response.data.sekolah.logo;
          this.model.foto_gedung = response.data.sekolah.foto_gedung;

        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/sekolah';
      });

      axios.get('api/sekolah/create')
      .then(response => {           
          response.data.user.forEach(element => {
            this.user.push(element);
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
        label:        "",
        description:  "",
        user:         "",
        npsn:         "",
        alamat:       "",
        logo:         "",
        foto_gedung:  "",
      },
      user: []
    }
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.put('api/sekolah/' + this.$route.params.id, {
            label:        this.model.label,
            description:  this.model.description,
            old_label:    this.model.old_label,
            user_id:      this.model.user.id,
            npsn:         this.model.npsn,
            alamat:       this.model.alamat,
            logo:         this.model.logo,
            foto_gedung:  this.model.foto_gedung,
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
      axios.get('api/sekolah/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.label        = response.data.sekolah.label;
            this.model.description  = response.data.sekolah.description;
            this.model.user         = response.data.sekolah.user;
            this.model.npsn         = response.data.sekolah.npsn;
            this.model.alamat       = response.data.sekolah.alamat;
            this.model.logo         = response.data.sekolah.logo;
            this.model.foto_gedung  = response.data.sekolah.foto_gedung;
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break ');
        });
    },
    back() {
      window.location = '#/admin/sekolah';
    }
  }
}
</script>
