<template>
  <v-container>
    <h4>Biodata</h4>
    <p>Isi biodata pasien</p>
    <v-form id="form">
      <v-text-field
        dense
        filled
        color="secondary"
        label="Nama"
        prepend-inner-icon="mdi-account"
      ></v-text-field>
      <v-text-field
        dense
        filled
        color="secondary"
        label="NIK"
        prepend-inner-icon="mdi-card-account-details"
      ></v-text-field>
      <v-select
        color="secondary"
        filled
        label="Jenis Kelamin"
        prepend-inner-icon="mdi-gender-male-female"
      >
      </v-select>
      <v-text-field
        dense
        filled
        color="secondary"
        label="Tempat Lahir"
        prepend-inner-icon="mdi-map-marker"
      ></v-text-field>
      <v-dialog
        ref="dialog"
        v-model="modal"
        :return-value.sync="date"
        persistent
        width="290px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            dense
            filled
            v-model="date"
            color="secondary"
            label="Tanggal Lahir"
            prepend-inner-icon="mdi-calendar"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker
          v-model="date"
          locale="id-ID"
          header-color="primary"
          color="secondary"
          scrollable
        >
          <v-spacer></v-spacer>
          <v-btn
            text
            color="secondary"
            @click="modal = false"
          >
            Cancel
          </v-btn>
          <v-btn
            text
            color="secondary"
            @click="$refs.dialog.save(date)"
          >
            OK
          </v-btn>
        </v-date-picker>
      </v-dialog>
      <v-text-field
        dense
        filled
        color="secondary"
        label="Kontak"
        prepend-inner-icon="mdi-phone"
      ></v-text-field>
      <div class="mt-2 mb-2"></div>
      <h4>Poly</h4>
      <p>Isi tujuan poly pasien</p>
      <v-select
        filled
        label="Poly"
      >

      </v-select>
      <v-btn color="primary">Simpan</v-btn>
      <v-btn
        text
        color="secondary"
      >Batal</v-btn>
    </v-form>

  </v-container>
</template>
<script>
export default {
  data() {
    return {
      modal: false,
      date: null,
    }
  },
}
</script>