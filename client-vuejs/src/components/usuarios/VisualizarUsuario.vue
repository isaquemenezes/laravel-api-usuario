<template>

    <div class="container">
  
      <div class="row justify-content-center">
        <div class="col-md-8 mt-5">
          <div class="card mt-5">
            <div class="card-header bg-primary text-white text-center">
              <h4 class="mb-0">Dados Usuário</h4>
            </div>

            <div 
              v-if="mensagemSucesso" 
              class="alert alert-success text-center" role="alert"
            >
              {{ mensagemSucesso }}
            </div>
  
            <div 
              v-if="mensagemErro" 
              class="alert alert-danger text-center" role="alert"
            >
              {{ mensagemErro }}
            </div>        
  
            <div class="card-body">
  
              <form @submit.prevent="submitUsuario">

                <div class="row mt-2">  
                  <div class="col-lg-6 form-group">
  
                    <label for="nome" class="form-label fw-bold text-primary fs-6">
                      Nome*:</label>
                    <input 
                      type="text" 
                      v-model="form.nome" 
                      id="nome" 
                      class="form-control form-control-sm"
                      readonly
                    >
  
                  </div>
  
                  <div class="col-lg-6 form-group">
                    <label for="email" class="form-label fw-bold text-primary fs-6">
                      E-mail</label>
                    <input 
                      type="email" 
                      v-model="form.email" 
                      id="email" 
                      class="form-control form-control-sm"
                      readonly
                    >
                  </div>
  
                </div>
  
                <div class="row mt-3">
  
                  <div class="col-lg-6 form-group">
                    <label for="cpf" class="form-label fw-bold text-primary fs-6">
                      CPF*:</label>
                    <input 
                      type="text" 
                      v-model="form.cpf" 
                      id="cpf" 
                      class="form-control form-control-sm" 
                      readonly
                    />
                  </div>
  
                  <div class="col-lg-6 form-group">
  
                    <label for="data_nascimento" class="form-label fw-bold text-primary fs-6">
                      Data Nascimento:</label>
                    <input 
                      type="date" 
                      v-model="form.data_nascimento" 
                      id="data_nascimento"
                      class="form-control form-control-sm" 
                      readonly
                    />
                  </div>
  
  
                </div>
  
                <div class="col-lg-12 form-group mt-3">
                  <label for="telefone" class="form-label fw-bold text-primary fs-6">
                    Telefone:</label>
                  <input 
                    type="text" 
                    v-model="form.telefone" 
                    id="telefone" class="form-control form-control-sm" 
                    readonly
                  />
                </div>
  
                <!-- Campos de Endereços -->
  
                <div class="row mt-3">
                  <div class="col-lg-6 form-group">
                    <label for="cep" class="form-label fw-bold text-primary fs-6">
                      CEP*:</label>
                    <input 
                      type="text" 
                      v-model="form.cep" 
                      class="form-control form-control-sm" 
                      readonly
                    />
  
                  </div>
  
                  <div class="col-lg-6 form-group">
                    <label for="estado" class="form-label fw-bold text-primary fs-6 ">
                      Estado:</label>
                    <input 
                      type="text"
                       v-model="form.estado" 
                      readonly 
                      class="form-control form-control-sm" 
                    />
                  </div>
  
                </div>
  
  
                <div class="row mt-3">
  
                  <div class="col-lg-6 form-group">
                    <label for="cidade" class="form-label fw-bold text-primary fs-6">
                      Cidade:</label>
                    <input 
                      type="text" 
                      v-model="form.cidade" 
                      readonly 
                      class="form-control form-control-sm" 
                      
                    />
  
                  </div>
  
                  <div class="col-lg-6 form-group">
  
                    <label for="bairro" class="form-label fw-bold text-primary fs-6">
                      Bairro:</label>
                    <input 
                      type="text" 
                      v-model="form.bairro" 
                      class="form-control form-control-sm" 
                      readonly
                    />
                  </div>
  
                </div>
  
  
                <div class="form-group mt-3">
                  <label for="endereco" class="form-label fw-bold text-primary fs-6">
                    Endereço:</label>
                  <input 
                    type="text" 
                    v-model="form.endereco" 
                    class="form-control form-control-sm" 
                    readonly
                  />
                </div>
                
                <div class="d-flex justify-content-start mt-3">

                  <button class="btn btn-danger" @click="baixarPdf">
                    Baixar PDF
                  </button>
                  
                </div>

              </form>
  
            </div>
          </div>
        </div>
      </div>
    </div>
  
  </template>
  
  <script>
  export default {
    props: ['id'],
  
    data() {
      return {
        form: {
          nome: '',
          email: '',
          cpf: '',
          data_nascimento: '',
          telefone: '',
          cep: '',
          estado: '',
          cidade: '',
          bairro: '',
          endereco: ''
        },

          mensagemSucesso: '',
        mensagemErro: ''

      
      };
    },
  
    mounted() {
      this.loadUsuario();
    },
  
    methods: {

        async loadUsuario() 
        {
            try {
            const response = await fetch(this.$apiRoute.usuarios.edit(this.id));
            const data = await response.json();
            
            if (response.ok) {
                this.form = data;
            } else {
                this.mensagemErro = data.message || 'Erro ao carregar dados do usuário';
            }

            } catch (error) {
                this.mensagemErro = 'Erro na requisição. Tente novamente.';
                console.error('Erro ao carregar dados do usuário:', error);
            }
        }, 

        async baixarPdf() {
            try {
             
              const response = await fetch(this.$apiRoute.usuarios.pdf(this.id), {
                method: 'GET',
                headers: {
                  'Accept': 'application/pdf'
                }
              });
              const blob = await response.blob();

              const link = document.createElement('a');
              link.href = window.URL.createObjectURL(blob);
              link.download = `usuario_${this.id}.pdf`;
              link.click();

            } catch (error) {
              console.error('Erro ao baixar PDF:', error);
              this.mensagemErro = 'Erro ao gerar o PDF. Tente novamente.';
            }
          
        }


       

    }
  };
  </script>