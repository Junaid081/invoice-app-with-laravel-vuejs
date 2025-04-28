<script setup>
import {onMounted, ref, reactive} from 'vue';


const invoices= ref([]);

onMounted(async () => {
    fetchInvoices();
});

const fetchInvoices = async () => {
    try{
        const response = await axios.get('/api/invoices');
        invoices.value = response.data.invoices; 
        // console.log(invoices);        
    }catch(error){
        console.log(error);
    }
}

const state = reactive({
    searchInvoice: [],
    isLoading: false,
});

const searchInvoices = async () => {
    console.log("searchInvoicevalue");
    console.log(state.searchInvoice);
    state.isLoading = true;
    try{
        const response = await axios.get('/api/search_invoices?s='+state.searchInvoice);
        invoices.value = response.data.invoices;
    }catch(error){
        console.log(error)
    }finally{
        state.isLoading = false;
    }
}

</script>
<template>
    <div class="container relative">
        <div v-if="state.isLoading">
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-80">
                <div class="loader"></div>
            </div>
        </div>
        <div class="invoices">
            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Invoices</h2>
                </div>
                <div>
                    <a class="btn btn-secondary">
                        New Invoice
                    </a>
                </div>
            </div>

            <div class="table card__content">
                <div class="table--filter">
                    <span class="table--filter--collapseBtn ">
                        <i class="fas fa-ellipsis-h"></i>
                    </span>
                    <div class="table--filter--listWrapper">
                        <ul class="table--filter--list">
                            <li>
                                <p class="table--filter--link table--filter--link--active">
                                    All
                                </p>
                            </li>
                            <li>
                                <p class="table--filter--link ">
                                    Paid
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table--search">
                    <div class="table--search--wrapper">
                        <select class="table--search--select" name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="relative">
                        <i class="table--search--input--icon fas fa-search "></i>
                        <input class="table--search--input" type="text" v-model="state.searchInvoice" @keyup="searchInvoices()" placeholder="Search invoice">
                    </div>
                </div>

                <div class="table--heading">
                    <p>ID</p>
                    <p>Date</p>
                    <p>Number</p>
                    <p>Customer</p>
                    <p>Due Date</p>
                    <p>Total</p>
                </div>

                <!-- item 1 -->
                <div class="table--items" v-for="invoice in invoices" :key="invoice.id" v-if="invoices.length > 0">
                    <a href="#" class="table--items--transactionId">{{ invoice.id }}</a>
                    <p>{{ invoice.date }}</p>
                    <p>{{ invoice.number }}</p>
                    <p v-if="invoice.customer != null">{{ invoice.customer.firstname }}</p>
                    <p v-else></p>
                    <p>{{ invoice.due_date }}</p>
                    <p> $ {{ invoice.total}}</p>
                </div>
                <div class="table--items" v-else>
                    <p> Invoice Not Found </p>
                </div>
            </div>

        </div>
    </div>
</template>

<style scoped>
.loader {
  width: 48px;
  height: 48px;
  border: 6px solid #3490dc;
  border-bottom-color: transparent;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>