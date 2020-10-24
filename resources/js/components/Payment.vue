<template>
  <div>
    <div class="row">
        <div class="col-10 offset-1 p-4 border rounded-lg">
            <div class="row text-black-50 mb-3 border-bottom">
                <div class="col-6">
                    <h1 class="h4 mr-2 d-inline-block">
                        Order #{{ order.id }}
                    </h1>
                    <span class="badge badge-pill badge-primary">{{ order.status_name }}</span>
                </div>
                <div class="col-6 text-right">
                    {{ order.created_at }}
                  </div>

                </div>
            <div class="row">
                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr v-for="detail in order.details" :key="detail.id">
                            <td>{{ detail.product.name }}</td>
                            <td>{{ detail.quantity }}</td>
                            <td>${{ detail.unit_price }}</td>
                          </tr>

                    </tbody>
                </table>
                <div class="col-12">
                    <div class="text-right text-info">
                        <strong>Total: </strong>
                        <span>${{ order.total_price }}</span>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="row">
                    <button
                        class="btn btn-outline-secondary"
                      @click="getSession('paymate')"
                    >
                      Paymate
                    </button>
                    <button
                      @click="getSession('placetopay')"
                        class="btn btn-dark"
                    >
                      Placetopay
                    </button>

                  </div>
      
    <div class="row mt-5">
        <div class="col-10 offset-1 p-4 border rounded-lg">
            <div class="row text-black-50 mb-3 border-bottom">
                <div class="col-12">
                    <h2 class="text-black-50 h4">Transactions</h2>
                </div>
            </div>
            <div class="row">
                <table class="table table-light">
                    <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Status</th>
                        <th>Created at</th>
                    </tr>
                    </thead>
                    <tbody>

                      <tr v-for="payment in order.payments" :key="payment.id">
                          <td>{{ payment.reference }}</td>
                          <td>{{ payment.status_name }}</td>
                          <td>{{ payment.created_at }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'Payment',
  props: {
    order: {
      type: Object,
      required: true
    },
    gateways: {
      type: Array,
      required: false,
      default: () => (['paymate', 'placetopay'])
    }
  },
  data() {
    return {
      gateway: 'paymate' 
    }
  },
  methods: {
    getSession(gateway) {
      axios.post('/api/payments', {
        order_id: this.order.id,
        payment_gateway: gateway
      })
      .then( ({ data }) => window.location = data.data.process_url  );
    },
    getInformation(payment) {
      axios.get(`/api/payments/${payment}`)
        .then( ({data}) => { const status = data.data.status; 
          if (status == 'Pending') {
            setTimeout(function(){
              window.location.reload()
            }, 1000 * 60 * 5);
          }
        } )
    }
  },
  created() {
   this.getInformation(this.order.payments.length); 
  }
}
</script>
