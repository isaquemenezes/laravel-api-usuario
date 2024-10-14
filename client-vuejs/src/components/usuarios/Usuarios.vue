<template>
  <main class="container">

    <div class="mt-3 my-3 p-3 bg-body rounded shadow-sm">
    </div>

    <div class="mt-5 my-3 p-3 bg-body rounded shadow-sm">

      <div class="d-flex justify-content-between">
        <h3 class="border-bottom pb-2 mb-0">Todos os Usuários</h3>

        <div class="d-flex justify-content-between">
          
          <router-link class="btn btn-success me-1" to="/cadastroUsuario">
            Cadastrar Usuário
          </router-link>

          <button @click="downloadPdf" class="btn btn-primary">Baixar PDF</button>
        </div>

      </div>

      <!-- Alertas de Sucesso e Erro -->
      <div v-if="mensagem" :class="`alert alert-${mensagemTipo}`" role="alert">
        {{ mensagem }}
      </div>

      <div v-if="usuarios.length == 0">
        <strong class="d-block mt-2"> Sem Usuário </strong>
      </div>

      <!-- start loop  -->
      <div class="d-flex text-body-secondary pt-3" v-for="usuario in usuarios" :key="usuario.id">

        <div class="pb-3 mb-0 small lh-sm border-bottom w-100">

          <div class="d-flex justify-content-between align-items-center">
            <strong class="text-gray-dark"><b>Nome: </b>{{ usuario.nome }}</strong>

            <div>
              <button 
                type="button" 
                class="btn btn-success me-1" 
                @click="showUsuario(usuario.id)"
              >Visualizar</button>
              
              <button 
                type="button" 
                class="btn btn-primary me-1" 
                @click="editarUsuario(usuario.id)"
              >Editar </button>

              <button 
                type="button" 
                class="btn btn-danger"
                @click="excluirUsuario(usuario.id)"
              >Excluir</button>

             

             
            </div>

          </div>

          <div class="d-flex justify-content-start">

            <div class="d-block">
              <b>CPF: </b> {{ usuario.cpf }}
            </div>

          </div>       


        </div>
      </div>
      <!-- end loop -->

     


    </div>
  </main>




</template>

<script>


export default {

  data() {
    return {
      usuarios: [],

      mensagem: '',
      mensagemTipo: ''
    };
  },

  mounted() {

    fetch(this.$apiRoute.usuarios.listar, {
      method: 'GET'
    })
      .then(response => response.json())
      .then(data => {
        this.usuarios = data;

        console.log('Dados dos usuarios:', data);
      })
      .catch(error => {
        console.error('Erro ao buscar os usuarios:', error);
      });
  },


  methods: {



    editarUsuario(id) {
      this.$router.push({ name: 'EditarUsuario', params: { id } });
    },

    showUsuario(id) {
      this.$router.push({ name: 'VizualizarUsuario', params: { id } });
    },


    async excluirUsuario(id) {
      if (confirm('Tem certeza de que deseja excluir este usuário?')) {
        try {
          const response = await fetch(this.$apiRoute.usuarios.delete(id), {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            }
          });

          if (response.ok) {

            this.usuarios = this.usuarios.filter(usuario => usuario.id !== id);
            this.exibirMensagem('Usuário excluído com sucesso.', 'success');

          } else {
            const data = await response.json();
            this.exibirMensagem(data.message || 'Erro ao excluir o usuário.', 'danger');
          }
        } catch (error) {
          this.exibirMensagem('Erro na requisição. Tente novamente.', 'danger');
          console.error('Erro ao excluir usuário:', error);
        }
      }
    },

    exibirMensagem(mensagem, tipo) {
      this.mensagem = mensagem;
      this.mensagemTipo = tipo;


      setTimeout(() => {
        this.mensagem = '';
        this.mensagemTipo = '';
      }, 4000);
    },

    async downloadPdf() {
      try {
       
        const response = await fetch(this.$apiRoute.usuarios.usuarios_pdf, {
              
          method: 'GET',
          headers: {
            'Content-Type': 'application/pdf',
          },
        });

        if (response.ok) 
        {
          const blob = await response.blob();
          const url = window.URL.createObjectURL(blob); 
          const link = document.createElement('a'); 
          link.href = url;
          link.setAttribute('download', 'usuarios.pdf');
          document.body.appendChild(link);
          link.click(); 
          link.remove(); 
        } else {
          alert('Erro ao gerar o PDF.');
        }
      } catch (error) {
        console.error('Erro ao gerar PDF:', error);
      }
    },


  }

};
</script>

<style scoped></style>