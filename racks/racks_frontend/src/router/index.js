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
    path: '/site_add/:id',
    name: 'SiteAddView',
    component: SiteAddView
  },
  {
    path: '/site_upd/:id',
    name: 'SiteUpdateView',
    component: SiteUpdateView
  },
  {
    path: '/building_add/:id',
    name: 'BuildingAddView',
    component: BuildingAddView
  },
  {
    path: '/building_upd/:id',
    name: 'BuildingUpdateView',
    component: BuildingUpdateView
  },
  {
    path: '/room_add/:id',
    name: 'RoomAddView',
    component: RoomAddView
  },
  {
    path: '/room_upd/:id',
    name: 'RoomUpdateView',
    component: RoomUpdateView
  },
  {
    path: '/rack_add/:id',
    name: 'RackAddView',
    component: RackAddView
  },
  {
    path: '/rack_upd/:id',
    name: 'RackUpdateView',
    component: RackUpdateView
  },
  {
    path: '/device_add/:id',
    name: 'DeviceAddView',
    component: DeviceAddView
  },
  {
    path: '/device_upd/:id',
    name: 'DeviceUpdateView',
    component: DeviceUpdateView
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
    // If logged in, or going to the Login page.
    if (token || to.name === 'LoginView') {
      // Continue to page.
      next()
    } else {
      // Not logged in, redirect to login.
      next({name: 'LoginView'})
    }
});

export default router
