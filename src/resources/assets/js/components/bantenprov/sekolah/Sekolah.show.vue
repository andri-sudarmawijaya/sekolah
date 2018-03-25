<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i>Sekolah {{ model.label }}

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
            <b>Label :</b> {{ model.label }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Jenis Sekolah :</b> {{ model.jenis_sekolah.jenis_sekolah }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>NPSN :</b> {{ model.npsn }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Alamat :</b> {{ model.alamat }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Logo :</b> {{ model.logo }}
          </div>
        </div>
        
        <div class="form-row mt-4">
          <div class="col-md">
            <b>Foto Gedung :</b> {{ model.foto_gedung }}
          </div>
        </div>     
      </vue-form>

    </div>
       <div class="card-footer text-muted">
        <div class="row">
          <div class="col-md">
            <b>Username :</b> {{ model.user.name }}
          </div>
          <div class="col-md">
            <div class="col-md text-right">Dibuat : {{ model.created_at }}</div>
            <div class="col-md text-right">Diperbaiki : {{ model.updated_at }}</div>
          </div>
        </div>
      </div>
  </div>
</template>


<script>
export default {
  mounted() {
    axios.get('api/sekolah/' + this.$route.params.id)
      .then(response => {
        if (response.data.status == true) {
          this.model.label          = response.data.sekolah.label;
          this.model.old_label      = response.data.sekolah.label;
          this.model.user           = response.data.sekolah.user;
          this.model.jenis_sekolah  = response.data.sekolah.jenis_sekolah;
          this.model.npsn           = response.data.sekolah.npsn;
          this.model.alamat         = response.data.sekolah.alamat;
          this.model.created_at     = response.data.sekolah.created_at;
          this.model.updated_at     = response.data.sekolah.updated_at;
          this.model.logo           = response.data.sekolah.logo;
          this.model.foto_gedung    = response.data.sekolah.foto_gedung;

        } 
        else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/sekolah';
      }),
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
        label:            "",
        user_id:          "",
        jenis_sekolah_id: "",
        npsn:             "",
        alamat:           "",
        logo:             "",
        foto_gedung:      "",
        created_at:       "",
        updated_at:       "",
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
            user_id:      this.model.user_id,
            npsn:         this.model.npsn,
            alamat:       this.model.alamat,
            logo:         this.model.logo,
            foto_gedung:  this.model.foto_gedung
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
            this.model.label = response.data.sekolah.label;
            this.model.description = response.data.sekolah.description;
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
