import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '@/views/HomeView.vue';
import LoginView from '@/views/LoginView.vue';
import DeviceView from '@/views/DeviceView.vue';
import RackView from '@/views/RackView.vue';
import TreeView from '@/views/TreeView.vue';
import UnitsView from '@/views/UnitsView.vue';
import SiteAddView from '@/views/SiteAddView.vue';
import SiteUpdateView from '@/views/SiteUpdateView.vue';
import RackAddView from '@/views/RackAddView.vue';
import RackUpdateView from '@/views/RackUpdateView.vue';
import DeviceAddView from '@/views/DeviceAddView.vue';
import DeviceUpdateView from '@/views/DeviceUpdateView.vue';
import BuildingAddView from '@/views/BuildingAddView.vue';
import BuildingUpdateView from '@/views/BuildingUpdateView.vue';
import RoomAddView from '@/views/RoomAddView.vue';
import RoomUpdateView from '@/views/RoomUpdateView.vue';
import ModalView from '@/views/ModalView.vue';


const routes = [
  {
    path: '/',
    name: 'HomeView',
    component: HomeView
  },
  {
    path: '/login',
    name: 'LoginView',
    component: LoginView
  },
  {
    path: '/device/:id',
    name: 'DeviceView',
    component: DeviceView
  },
  {
    path: '/rack/:id',
    name: 'RackView',
    component: RackView
  },
  {
    path: '/tree',
    name: 'TreeView',
    component: TreeView
  },
  {
    path: '/units/:id',
    name: 'UnitsView',
    component: UnitsView
  },
  {
    path: '/site/create/:department_id',
    name: 'SiteAddView',
    component: SiteAddView
  },
  {
    path: '/site/:id/update',
    name: 'SiteUpdateView',
    component: SiteUpdateView
  },
  {
    path: '/building/create/:site_id',
    name: 'BuildingAddView',
    component: BuildingAddView
  },
  {
    path: '/building/:id/update',
    name: 'BuildingUpdateView',
    component: BuildingUpdateView
  },
  {
    path: '/room/create/:building_id',
    name: 'RoomAddView',
    component: RoomAddView
  },
  {
    path: '/room/:id/update',
    name: 'RoomUpdateView',
    component: RoomUpdateView
  },
  {
    path: '/rack/create/:room_id',
    name: 'RackAddView',
    component: RackAddView
  },
  {
    path: '/rack/:id/update',
    name: 'RackUpdateView',
    component: RackUpdateView
  },
  {
    path: '/device/create/:rack_id',
    name: 'DeviceAddView',
    component: DeviceAddView
  },
  {
    path: '/device/:id/update',
    name: 'DeviceUpdateView',
    component: DeviceUpdateView
  },
  {
    path: '/modal',
    name: 'ModalView',
    component: ModalView
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
    if (token || to.name === 'LoginView') {
      next()
    } else {
      next({name: 'LoginView'})
    }
  }
);


export default router
