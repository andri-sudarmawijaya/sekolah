<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i>Prodi sekolah {{ model.keterangan }}

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
            <b>Sekolah :</b> {{ model.sekolah}}
          </div>
        </div>
        <div class="form-row mt-4">
          <div class="col-md">
            <b>Program Keahlian :</b> {{ model.program_keahlian }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Keterangan :</b> {{ model.keterangan }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Kuota Siswa :</b> {{ model.kuota_siswa }}
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
    axios.get('api/prodi-sekolah/' + this.$route.params.id)
      .then(response => {
        if (response.data.status == true) {
          this.model.sekolah          = response.data.sekolah.sekolah.label;
          this.model.program_keahlian = response.data.sekolah.program_keahlian.label;
          this.model.user             = response.data.sekolah.user;
          this.model.keterangan       = response.data.sekolah.keterangan;
          this.model.kuota_siswa      = response.data.sekolah.kuota_siswa;
          this.model.created_at       = response.data.sekolah.created_at;
          this.model.updated_at       = response.data.sekolah.updated_at;

        }
        else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break1');
        window.location.href = '#/admin/prodi-sekolah';
      }),
      axios.get('api/prodi-sekolah/create')
      .then(response => {
          response.data.user.forEach(element => {
            this.user.push(element);
          });

          response.data.sekolah.forEach(element => {
            this.sekolah.push(element);
          });

          response.data.program_keahlian.forEach(element => {
            this.program_keahlian.push(element);
          });
      })
      .catch(function(response) {
        alert('Break2');
        window.location = '#/admin/prodi-sekolah';
      })

  },
  data() {
    return {
      state: {},
      model: {
        sekolah_id:       "",
        user_id:          "",
        keterangan:       "",
        kuota_siswa:      "",
        program_keahlian: "",
        created_at:       "",
        updated_at:       "",

      },
      user: [],
      sekolah: [],
      program_keahlian: [],
    }
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.put('api/prodi-sekolah/' + this.$route.params.id, {
            sekolah_id:   this.model.sekolah_id,
            user_id:      this.model.user_id,
            keterangan:   this.model.keterangan,
            kuota_siswa:  this.model.kuota_siswa,
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
      window.location = '#/admin/prodi-sekolah';
    }
  }
}
</script>