<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-2xl pb-4">
    <Message :messageProps="messageProps" />
  </div>
  <div class="container min-h-screen px-4 mx-auto flex flex-wrap justify-between text-xl pl-8 font-sans tracking-tight font-thin">
    <ul id="racks">
      <li v-for="region in regions">
      <span :id="`e2e_${region.region_name.replaceAll(' ', '_')}`" @click="expandTree" class="caret">
        {{region.region_name}}
      </span>
        <ul class="nested ">
          <li v-for="department in departments">
          <template v-if="region.id == department.region_id">
          <span :id="`e2e_${department.department_name.replaceAll(' ', '_')}`" @click="expandTree" class="caret">
              {{ truncate(department.department_name, 50) }}
            <router-link :to="{path: '/site/create/' + department.id}" target="_blank">
              <button :id="`e2e_${department.department_name.replaceAll(' ', '_')}_add_button`"
                type="button" class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
                px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Add site
              </button>
            </router-link>
          </span>
          </template>
            <ul class="nested ">
              <li v-for="site in sites">
              <template v-if="department.id == site.department_id">
              <span :id="`e2e_${site.site_name.replaceAll(' ', '_')}`" @click="expandTree" class="caret">
                {{ truncate(site.site_name, 50) }}
                <router-link :to="{path: '/building/create/' + site.id}" target="_blank">
                  <button :id="`e2e_${site.site_name.replaceAll(' ', '_')}_add_button`" class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
                    px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Add building
                  </button>
                </router-link>
                <router-link :to="{path: '/site/' + site.id + '/update'}" target="_blank">
                  <button class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
                    px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Edit
                  </button>
                </router-link>
                  <button class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
                    px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
                    @click="deleteSite(site.id, site.site_name)">
                    Delete
                  </button>
              </span>
              </template>
                <ul class="nested ">
                  <li v-for="building in buildings">
                  <template v-if="site.id == building.site_id">
                  <span :id="`e2e_${building.building_name.replaceAll(' ', '_')}`" @click="expandTree" class="caret">
                    {{ truncate(building.building_name, 50) }}
                    <router-link :to="{path: '/room/create/' + building.id}" target="_blank">
                      <button :id="`e2e_${building.building_name.replaceAll(' ', '_')}_add_button`" class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
                        px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Add room
                      </button>
                    </router-link>
                    <router-link :to="{path: '/building/' + building.id + '/update'}" target="_blank">
                      <button class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
                        px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Edit
                      </button>
                    </router-link>
                      <button class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
                        px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
                        @click="deleteBuilding(building.id, building.building_name)">
                        Delete
                      </button>
                  </span>
                  </template>
                    <ul class="nested ">
                      <li v-for="room in rooms">
                      <template v-if="building.id == room.building_id">
                      <span :id="`e2e_${room.room_name.replaceAll(' ', '_')}`" @click="expandTree" class="caret">
                        {{ truncate(room.room_name, 50) }}
                        <router-link :to="{path: '/rack/create/' + room.id}" target="_blank">
                          <button :id="`e2e_${room.room_name.replaceAll(' ', '_')}_add_button`" class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
                            px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            Add rack
                          </button>
                        </router-link>
                        <router-link :to="{path: '/room/' + room.id + '/update'}" target="_blank">
                          <button class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
                            px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            Edit
                          </button>
                        </router-link>
                          <button class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
                            px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                            @click="deleteRoom(room.id, room.room_name)">
                            Delete
                          </button>
                      </span>
                      </template>
                        <ul class="nested ">
                          <li v-for="rack in racks">
                          <template v-if="room.id == rack.room_id">
                          <span>
                            <router-link :to="{path: '/units/' + rack.id}" target="_blank">
                              <text class="text-blue-300">&#9873; </text>
                              <a :id="`e2e_${rack.rack_name.replaceAll(' ', '_')}`" class="group transition duration-300">
                                {{ truncate(rack.rack_name, 40) }}
                                <span class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-1 bg-blue-500"></span>
                              </a>
                            </router-link>
                          </span>
                          </template>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>      
          </li> 
        </ul>
      </li>
    </ul>
  </div>
</template>

<script>
import { getObject, deleteObject } from '@/api';
import { truncate } from '@/filters'
import Message from '@/components/Message.vue';


export default {
  name: 'TreeView',
  components: {
    Message
  },
  data() {
    return {
      regions: {},
      departments: {},
      sites: {},
      buildings: {},
      rooms: {},
      racks: {},
      messageProps: {
        message: ''
      }
    }
  },
  created() {
    this.getTreeData();
  },
  methods: {
    expandTree(element) {
      // Expand nested tree
      const nestedElement = element.target.parentElement.querySelector(".nested");
      if (nestedElement !== null) {
        nestedElement.classList.toggle("active");
        element.target.classList.toggle("caret-down");
      } 
    },
    getTreeData() {
      this.getRegions();
      this.getDepartments();
      this.getSites();
      this.getBuildings();
      this.getRooms();
      this.getRacks();
    },
    async getRegions() {
      this.regions = await getObject('regions', '/region/all', null);
    },
    async getDepartments() {
      this.departments = await getObject('departments', '/department/all', null);
    },
    async getSites() {
      this.sites = await getObject('sites', '/site/all', null);
    },
    async getBuildings() {
      this.buildings = await getObject('buildings', '/building/all', null);
    },
    async getRooms() {
      this.rooms = await getObject('rooms', '/room/all', null);
    },
    async getRacks() {
      this.racks = await getObject('racks', '/rack/all/partial', null);
    },
    async deleteSite(id, siteName) {
      const payload = {
        id: id,
      }
      if (confirm(`Do you really want to delete site ${siteName} and all releated items?`)) {
        this.messageProps.message = await deleteObject('site', `/site/${id}/delete`, payload);
        console.log(this.messageProps.message);
        this.getSites();
      }
    },
    async deleteBuilding(id, buildingName) {
      const payload = {
        id: id,
      }
      if (confirm(`Do you really want to delete building ${buildingName} and all releated items?`)) {
        this.messageProps.message = await deleteObject('building', `/building/${id}/delete`, payload);
        this.getBuildings();
      }
    },
    async deleteRoom(id, roomName) {
      const payload = {
        id: id,
      }
      if (confirm(`Do you really want to delete room ${roomName} and all releated items?`)) {
        this.messageProps.message = await deleteObject('room', `/room/${id}/delete`, payload);
        this.getRooms();
      }
    },
    truncate: truncate,
  },
}
</script>

<style scoped>
body {
  font-size: 200%;
}

ul, #racks {
  list-style-type: none;
}

#racks {
  margin: 0;
  padding: 0;
  
}

.caret {
  cursor: pointer;
  user-select: none;
}

.caret::before {
  content: "\232A";
  -webkit-text-stroke: 2px;
  font-size:12px;
  color: #70a7f8;
  display: inline-block;
  margin-right: 6px;
}

.caret-down::before {
  transform: rotate(30deg);  
}

.nested {
  display: none;
  padding-left: 30px;
}

.active {
  display: block;
}
</style>