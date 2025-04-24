<template>
  <q-page class="q-pa-md">
    <q-form @submit.prevent="guardarPedido">
      <div class="row q-col-gutter-sm">
        <div class="col-12">
          <q-input v-model="observaciones" label="Observaciones" outlined />
        </div>

        <div class="col-12">
          <q-btn label="Agregar Producto" @click="agregarProducto" color="primary" />
          <q-btn label="Guardar Pedido" type="submit" color="green" :loading="loading" class="q-ml-sm" />
        </div>

        <div class="col-12 q-mt-md">
          <q-markup-table dense flat bordered>
            <thead>
            <tr>
              <th>#</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(d, i) in detalles" :key="i">
              <td>{{ i + 1 }}</td>
              <td><q-input v-model="d.producto_id" dense label="ID" /></td>
              <td><q-input v-model.number="d.cantidad" type="number" dense /></td>
              <td><q-input v-model.number="d.precio" type="number" dense /></td>
              <td>{{ (d.precio * d.cantidad).toFixed(2) }}</td>
            </tr>
            </tbody>
          </q-markup-table>
        </div>
      </div>
    </q-form>
  </q-page>
</template>

<script>
export default {
  data() {
    return {
      observaciones: '',
      detalles: [],
      loading: false
    };
  },
  methods: {
    agregarProducto() {
      this.detalles.push({ producto_id: '', cantidad: 1, precio: 0 });
    },
    guardarPedido() {
      this.loading = true;
      this.$axios.post('/pedidos', {
        observaciones: this.observaciones,
        detalles: this.detalles
      }).then(() => {
        this.$q.notify({ type: 'positive', message: 'Pedido guardado' });
        this.$router.push('/pedidos');
      }).catch(() => {
        this.$q.notify({ type: 'negative', message: 'Error al guardar' });
      }).finally(() => {
        this.loading = false;
      });
    }
  }
};
</script>
