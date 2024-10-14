<template>


  <div class="container">

    <div class="row justify-content-center">
      <div class="col-md-8 mt-5">
        <div class="card mt-5">
          <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Adicionar Novo Usuário</h4>
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
                    @blur="fetchAddress" 
                    class="form-control form-control-sm" 
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
                    readonly class="form-control form-control-sm" 
                  />

                </div>

                <div class="col-lg-6 form-group">

                  <label for="bairro" class="form-label fw-bold text-primary fs-6">
                    Bairro:</label>
                  <input 
                    type="text" 
                    v-model="form.bairro" 
                    class="form-control form-control-sm" 
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
                />
              </div>

              <button type="submit" class="btn btn-success mt-3">Salvar</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>

export default {

  data() {
    return {
      form: {
        nome: '',
        email: '',
        cpf:'',
        data_nascimento:'',
        telefone:'',
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

  methods: {

    async fetchAddress() {
      if (this.form.cep.length === 8) {
        const response = await fetch(`https://viacep.com.br/ws/${this.form.cep}/json/`);
        const data = await response.json();

        if (!data.erro) {
          this.form.estado = data.uf;
          this.form.cidade = data.localidade;
          this.form.bairro = data.bairro;
          this.form.endereco = data.logradouro;
        } else {
          this.mensagemErro = 'CEP inválido';
        }
      }
    },
   
      async submitUsuario() {
      try {
        const response = await fetch(this.$apiRoute.usuarios.create, {
          method: 'POST',
          body: JSON.stringify(this.form),
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          }
        });

        // Verifica se o Content-Type é JSON antes de tentar processar a resposta
        const contentType = response.headers.get('content-type');
        
        if (contentType && contentType.includes('application/json')) 
        {
          const data = await response.json();

          if (response.ok) {
            this.mensagemSucesso = 'Usuário criado com sucesso!';
            this.mensagemErro = '';

            setTimeout(() => {
              location.reload();
            }, 3000);


          } else {
            this.mensagemErro = data.message || 'Erro ao criar o usuário';
            this.mensagemSucesso = ''; 
          }
        } else {
          const text = await response.text();
          this.mensagemErro = `Erro inesperado: ${text}`;
          this.mensagemSucesso = ''; 
        }

      } catch (error) {
        this.mensagemErro = 'Erro na requisição. Tente novamente.';
        this.mensagemSucesso = '';
        console.error('Erro ao enviar dados:', error);
      }
    }


  },

  mounted() {
  },

};
</script>

<style></style>
