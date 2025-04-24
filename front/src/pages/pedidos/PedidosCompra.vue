<template>
  <q-page class="q-pa-xs">
    <q-card flat bordered>
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6">Nuevo Pedido</div>
        <q-btn flat round dense icon="arrow_back" @click="$router.go(-1)" />
      </q-card-section>

      <q-card-section class="q-pa-none">
        <q-form @submit="confirmarPedido">
          <div class="row">
            <!-- Búsqueda de productos -->
            <div class="col-12 col-md-7 q-pa-xs">
              <div class="flex flex-center">
                <q-pagination
                  v-model="paginacion.page"
                  :max="Math.ceil(paginacion.rowsNumber / paginacion.rowsPerPage)"
                  max-pages="5"
                  size="xs"
                  @update:modelValue="obtenerProductos"
                />
              </div>
              <q-input v-model="busqueda" outlined clearable label="Buscar producto" dense debounce="300" @update:modelValue="obtenerProductos">
                <template v-slot:append>
                  <q-btn flat round dense icon="search" />
                </template>
              </q-input>
              <div class="row">
                <div class="col-6 col-md-4 q-mb-sm" v-for="producto in productos" :key="producto.id">
                  <q-card flat bordered class="cursor-pointer" @click="agregarProducto(producto)">
                    <q-img :src="`${$url}../images/${producto.imagen}`" style="height: 120px;">
                      <div class="absolute-bottom text-center text-white pm-none">
                        <div class="text-bold">{{ producto.nombre }}</div>
                        <small>Stock: {{ producto.stock }}</small>
                      </div>
                    </q-img>
                  </q-card>
                </div>
              </div>
            </div>

            <!-- Productos seleccionados -->
            <div class="col-12 col-md-5 q-pa-xs">
              <q-markup-table dense wrap-cells flat bordered>
                <thead>
                <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
<!--                  <th>Precio</th>-->
                  <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, i) in productosPedido" :key="i">
                  <td>{{ item.producto?.nombre }}</td>
                  <td><q-input v-model.number="item.cantidad" type="number" dense /></td>
<!--                  <td><q-input v-model.number="item.precio" type="number" dense /></td>-->
                  <td class="text-right">{{ (item.precio * item.cantidad).toFixed(2) }} Bs</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                  <td colspan="3" class="text-right">Total</td>
                  <td class="text-right text-bold">{{ totalPedido }} Bs</td>
                </tr>
                </tfoot>
              </q-markup-table>
              <q-input v-model="observaciones" label="Observaciones" dense outlined class="q-mt-sm" />
              <q-btn label="Guardar Pedido" type="submit" color="primary" class="full-width q-mt-md" :loading="cargando" />
            </div>
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
export default {
  name: 'PedidosCreate',
  data() {
    return {
      productos: [],
      busqueda: '',
      productosPedido: [],
      observaciones: '',
      cargando: false,
      paginacion: {
        page: 1,
        rowsPerPage: 12,
        rowsNumber: 0
      }
    };
  },
  computed: {
    totalPedido() {
      return this.productosPedido.reduce((sum, p) => sum + (p.cantidad * p.precio), 0).toFixed(2);
    }
  },
  methods: {
    obtenerProductos() {
      this.$axios.get('productos', {
        params: {
          search: this.busqueda,
          page: this.paginacion.page,
          per_page: this.paginacion.rowsPerPage
        }
      }).then(res => {
        this.productos = res.data.data;
        this.paginacion.rowsNumber = res.data.total;
      });
    },
    agregarProducto(producto) {
      const existe = this.productosPedido.find(p => p.producto_id === producto.id);
      if (existe) {
        existe.cantidad += 1;
      } else {
        this.productosPedido.push({
          producto_id: producto.id,
          cantidad: 1,
          precio: 0,
          producto: producto
        });
      }
    },
    confirmarPedido() {
      if (this.productosPedido.length === 0) {
        return this.$alert.error("Agrega al menos un producto");
      }
      this.cargando = true;
      const data = {
        detalles: this.productosPedido.map(p => ({
          producto_id: p.producto_id,
          cantidad: p.cantidad,
          precio: p.precio
        })),
        observaciones: this.observaciones
      };
      this.$axios.post('pedidos', data).then(() => {
        this.$alert.success("Pedido registrado");
        this.$router.push('/pedidos');
      }).catch(() => {
        this.$alert.error("Error al guardar pedido");
      }).finally(() => {
        this.cargando = false;
      });
    }
  },
  mounted() {
    this.obtenerProductos();
  }
};
</script>
