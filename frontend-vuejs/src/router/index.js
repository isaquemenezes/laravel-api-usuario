import { createRouter, createWebHistory } from 'vue-router';
import CadastroUsuario from '../views/CadastroUsuarioView.vue';
import EditarUsuario from '../views/EditarUsuarioView.vue';
import Usuarios from '@/components/usuarios/Usuarios.vue';
import VisualizarUsuario from '../components/usuarios/VisualizarUsuario.vue';

const routes = [
  {
    
    path: '/',
    name: 'Usuarios',
    component: Usuarios,
   
  },

  {
    path: '/cadastroUsuario',
    name: 'CadastroUsuario',
    component: CadastroUsuario
  },

  {
    path: '/editarUsuario/:id',
    name: 'EditarUsuario',
    component: EditarUsuario,
    props: true
  },

  {
    path: '/usuario/:id',
    name: 'VizualizarUsuario',
    component: VisualizarUsuario,
    props: true
  }

 
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router