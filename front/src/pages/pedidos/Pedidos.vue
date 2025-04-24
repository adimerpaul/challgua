<template>
  <q-page class="q-pa-xs">
    <!-- Estadísticas de pedidos -->
    <div class="row">
      <div class="col-12 col-md-4 q-pa-xs">
        <q-card flat bordered>
          <q-card-section class="q-pa-none">
            <q-item class="bg-green">
              <q-item-section avatar>
                <q-icon name="shopping_cart" size="50px" color="white" />
              </q-item-section>
              <q-item-section>
                <q-item-label caption class="text-white">Pedidos Pendientes</q-item-label>
                <q-item-label class="text-white text-h4">{{ totalPendientes }}</q-item-label>
              </q-item-section>
            </q-item>
          </q-card-section>
        </q-card>
      </div>
      <div class="col-12 col-md-4 q-pa-xs">
        <q-card flat bordered>
          <q-card-section class="q-pa-none">
            <q-item class="bg-blue">
              <q-item-section avatar>
                <q-icon name="local_shipping" size="50px" color="white" />
              </q-item-section>
              <q-item-section>
                <q-item-label caption class="text-white">Pedidos Enviados</q-item-label>
                <q-item-label class="text-white text-h4">{{ totalEnviados }}</q-item-label>
              </q-item-section>
            </q-item>
          </q-card-section>
        </q-card>
      </div>
    </div>

    <!-- Filtros -->
    <q-card flat bordered class="q-mt-sm">
      <q-card-section class="q-pa-none">
        <div class="row q-col-gutter-sm q-pa-sm">
          <div class="col-12 col-md-3">
            <q-input v-model="fechaInicio" label="Fecha inicio" dense outlined type="date" />
          </div>
          <div class="col-12 col-md-3">
            <q-input v-model="fechaFin" label="Fecha fin" dense outlined type="date" />
          </div>
          <div class="col-12 col-md-3">
            <q-btn color="primary" label="Buscar" icon="search" @click="cargarPedidos" :loading="loading" no-caps />
          </div>
          <div class="col-12 col-md-3">
            <q-btn color="positive" label="Nuevo Pedido" icon="add_circle_outline" @click="$router.push('pedidosCompra')" no-caps />
          </div>
        </div>
      </q-card-section>
    </q-card>

    <!-- Tabla de pedidos -->
    <q-markup-table dense wrap-cells>
      <thead>
      <tr class="bg-primary text-white">
        <th>ID</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Usuario</th>
        <th>Estado</th>
        <th>Total</th>
        <th>Observaciones</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="pedido in pedidos" :key="pedido.id">
        <td>{{ pedido.id }}</td>
        <td>{{ pedido.fecha }}</td>
        <td>{{ pedido.hora }}</td>
        <td>{{ pedido.user?.name }}</td>
        <td><q-chip :color="pedido.estado === 'Pendiente' ? 'orange' : 'blue'" class="text-white" dense>{{ pedido.estado }}</q-chip></td>
        <td class="text-bold">{{ pedido.total }} Bs</td>
        <td>{{ pedido.observaciones }}</td>
      </tr>
      </tbody>
    </q-markup-table>
  </q-page>
</template>

<script>
import moment from 'moment';

export default {
  data() {
    return {
      pedidos: [],
      fechaInicio: moment().format('YYYY-MM-DD'),
      fechaFin: moment().format('YYYY-MM-DD'),
      loading: false
    };
  },
  computed: {
    totalPendientes() {
      return this.pedidos.filter(p => p.estado === 'Pendiente').length;
    },
    totalEnviados() {
      return this.pedidos.filter(p => p.estado === 'Enviado').length;
    }
  },
  methods: {
    cargarPedidos() {
      this.loading = true;
      console.log(this.fechaInicio, this.fechaFin);
      this.$axios.get('/pedidos', {
        params: {
          fechaInicio: this.fechaInicio,
          fechaFin: this.fechaFin
        }
      }).then(res => {
        this.pedidos = res.data.data || res.data;
      }).catch(() => {
        this.$alert.error("Error al obtener pedidos");
      }).finally(() => {
        this.loading = false;
      });
    }
  },
  mounted() {
    this.cargarPedidos();
  }
};
</script>
