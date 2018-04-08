<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> {{ model.label }}

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
            <b>Nama Sekolah :</b> {{ model.label }}
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

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Provinsi :</b> {{ model.province_id }}
          </div>
        </div> 

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Kota/Kabupaten :</b> {{ model.city_id }}
          </div>
        </div> 

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Kecamatan :</b> {{ model.district_id }}
          </div>
        </div> 

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Kelurahan :</b> {{ model.village_id }}
          </div>
        </div> 

        <div class="form-row mt-4">
          <div class="col-md">
            <b>No Telepon :</b> {{ model.no_telp }}
          </div>
        </div> 

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Email :</b> {{ model.email }}
          </div>
        </div> 

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Zona :</b> {{ model.zona_id }}
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
          this.model.user           = response.data.sekolah.user;
          this.model.jenis_sekolah  = response.data.sekolah.jenis_sekolah;
          this.model.npsn           = response.data.sekolah.npsn;
          this.model.alamat         = response.data.sekolah.alamat;
          this.model.created_at     = response.data.sekolah.created_at;
          this.model.updated_at     = response.data.sekolah.updated_at;
          this.model.logo           = response.data.sekolah.logo;
          this.model.foto_gedung    = response.data.sekolah.foto_gedung;
          this.model.province_id    = response.data.sekolah.province_id;
          this.model.city_id        = response.data.sekolah.city_id;
          this.model.district_id    = response.data.sekolah.district_id;
          this.model.village_id     = response.data.sekolah.village_id;
          this.model.no_telp        = response.data.sekolah.no_telp;
          this.model.email          = response.data.sekolah.email;
          this.model.zona_id        = response.data.sekolah.zona_id;

        } 
        else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/sekolah';
      })
  },
  data() {
    return {
      state: {},
      model: {        
        label:            "",
        user:          "",
        jenis_sekolah: "",
        npsn:             "",
        alamat:           "",
        logo:             "",
        foto_gedung:      "",
        province_id: "",
        city_id: "",
        district_id: "",
        village_id: "",
        no_telp: "",
        email: "",
        zona_id: "",
        created_at:       "",
        updated_at:       "",
        user:""
      },
      user: []
    }
  },
  methods: {    
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