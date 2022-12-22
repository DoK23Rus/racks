<template>
  <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-xl">
      <Message :messageProps="messageProps" />
    </div>
    Device №{{ device.id }}
    <router-link :to="{path: '/device/' + device.id + '/update'}" target="_blank">
      <button id="e2e_device_edit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
        px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
        Edit
      </button>
    </router-link>
    <button class="text-white bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
      px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
      @click="deleteDevice(device.id, `${device.deviceVendor} ${device.deviceModel}`)">
      Delete
    </button>
    <br>
      <div class="text-xs pb-4 text-slate-500">
        {{ device.regionName }} &#9002; {{ device.departmentName }} &#9002; 
        {{ device.siteName }} &#9002; {{ device.buildingName }} &#9002; 
        {{ device.roomName }} &#9002; {{ device.rackName }}
      </div>
  <div class="text-base">
    Status: <text class="text-slate-500">{{ device.status }}</text>
    <br>
      Description: <text class="text-slate-500">{{ device.deviceDescription }}</text>
    <br>
      <template v-if="device.frontsideLocation">
        Located on the front of the rack: <text class="text-slate-500">Yes</text>
      </template>
      <template v-else="device.frontsideLocation">
        Located on the front of the rack: <text class="text-slate-500">No</text>
      </template>
    <br>
      Installed in: <a class="text-slate-500" v-bind:href="'/rack/' + device.rackId" target="_blank">
        <text class="text-blue-300">&#9873; </text>
        Rack №{{ device.rackId }}</a>
    <br>
      First unit: <text class="text-slate-500">{{ device.firstUnit }}</text>
    <br>
      Last unit: <text class="text-slate-500">{{ device.lastUnit }}</text>
    <br>
      Ownership: <text class="text-slate-500">{{ device.ownership }}</text>
    <br>
      Responsible: <text class="text-slate-500">{{ device.responsible }}</text>
    <br>
      Project: <text class="text-slate-500">{{ device.project }}</text>
    <br>
      Inventory number: <text class="text-slate-500">{{ device.deviceInventoryNumber}}</text>
    <br>
      Financially responsible: <text class="text-slate-500">{{ device.financiallyResponsiblePerson }}</text>
    <br>
      Fixed asset: <text class="text-slate-500">{{ device.fixedAsset }}</text>
    <br>
      <template v-if="device.link">
        Link to docs: <a class="text-slate-500" href="{{ device.link }}"><text class="text-blue-300">&#9873; </text>
        {{ device.link }}</a>
      </template>
      <template v-else>
        Link to docs:
      </template>
    <br>
    <br>
      Vendor: <text class="text-slate-500">{{ device.deviceVendor }}</text>
    <br>
      Model: <text class="text-slate-500">{{ device.deviceModel }}</text>
    <br>
      Device type: <text class="text-slate-500">{{ device.deviceType }}</text>
    <br>
      Hostname: <text class="text-slate-500">{{ device.deviceHostname }}</text>
    <br>
      <template v-if="device.ip != null">
        IP-address: <text class="text-slate-500">{{ device.ip }}</text>
      </template>
      <template v-else>
        IP-address:
      </template>
    <br>
      <template v-if="device.deviceStack != null">
        Stack/Reserve (reserve ID): 
        <a class="text-slate-500" v-bind:href="'/device/' + device.deviceStack" 
        target="_blank">
        <text class="text-blue-300">&#9873; </text>
        Device №{{ device.deviceStack }}</a>
      </template>
      <template v-else>
        Stack/Reserve (reserve ID):
      </template>
    <br>
      <template v-if="device.portsAmout != null">
        Port capacity: <text class="text-slate-500">{{ device.portsAmout }}</text>
      </template>
      <template>
        Port capacity:
      </template>
    <br>
      Software version: <text class="text-slate-500">{{ device.version }}</text>
    <br>
      Serial number: <text class="text-slate-500">{{ device.deviceSerialNumber }}</text>
    <br>
      Socket type: <text class="text-slate-500">{{ device.powerType }}</text>
    <br>
      <template v-if="device.powerW != null">
        Power requirement (W): <text class="text-slate-500">{{ device.powerW }}</text>
      </template>
      <template v-else>
        Power requirement (W):
      </template>
    <br>
      <template v-if="device.powerV != null">
        Voltage (V): <text class="text-slate-500">{{ device.powerV }}</text>
      </template>
      <template v-else>
        Voltage (V):
      </template>
  </div>
    <br>
      <div class="text-xs">
          Updated by: <text class="text-slate-500">{{ device.updatedBy }}</text>
        <br>
          Updated at: <text class="text-slate-500">{{ device.updatedAt }}</text>
      </div>
  </div>
</template>

<script>
import { getObject, deleteObject } from '@/api';
import Message from '@/components/Message.vue';


export default {
  name: 'DeviceView',
  components: {
    Message
  },
  data() {
    return {
      device: {
        id: this.$route.params.id,
        firstUnit: null,
        lastUnit: null,
        frontsideLocation: true,
        status: 'Device active',
        deviceType: 'Other',
        deviceVendor: '',
        deviceModel: '',
        deviceHostname: '',
        ip: null,
        deviceStack: null,
        portsAmout: null,
        version: '',
        powerType: 'IEC C14 socket',
        powerW: null,
        powerV: null,
        powerACDC: 'AC',
        deviceSerialNumber: '',
        deviceDescription: '',
        project: '',
        ownership: 'Our department',
        responsible: '',
        financiallyResponsiblePerson: '',
        deviceInventoryNumber: '',
        fixedAsset: '',
        link:'',
        updatedBy: '',
        updatedAt: '',
        rackId: '',
        rackName: '',
        roomName: '',
        buildingName: '',
        siteName: '',
        departmentName: '',
        regionName: ''
      },
      messageProps: {
        message: ''
      },
    }
  },
  mounted() {
    this.getDevice();
  },
  methods: {
    async getDevice() {
      // Get device data
      const response = await getObject('device', '/device/', this.$route.params.id);
      this.messageProps.message = response;
      this.device.firstUnit = response.first_unit;
      this.device.lastUnit = response.last_unit;
      this.device.frontsideLocation = response.frontside_location;
      this.device.status = response.status;
      this.device.deviceType = response.device_type;
      this.device.deviceVendor = response.device_vendor;
      this.device.deviceModel = response.device_model;
      this.device.deviceHostname = response.device_hostname;
      this.device.ip = response.ip;
      this.device.deviceStack = response.device_stack;
      this.device.portsAmout = response.ports_amout;
      this.device.version = response.version;
      this.device.powerType = response.power_type;
      this.device.powerW = response.power_w;
      this.device.powerV = response.power_v;
      this.device.powerACDC = response.power_ac_dc;
      this.device.deviceSerialNumber = response.device_serial_number;
      this.device.deviceDescription = response.device_description;
      this.device.project = response.project;
      this.device.ownership = response.ownership;
      this.device.responsible = response.responsible;
      this.device.financiallyResponsiblePerson = response.financially_responsible_person;
      this.device.deviceInventoryNumber = response.device_inventory_number;
      this.device.fixedAsset = response.fixed_asset;
      this.device.link = response.link;
      this.device.updatedBy = response.updated_by;
      this.device.updatedAt = response.updated_at;
      this.device.rackId = response.rack_id;
      this.device.rackName = response.rack_name;
      this.device.roomName = response.room_name;
      this.device.buildingName = response.building_name;
      this.device.siteName = response.site_name;
      this.device.departmentName = response.department_name;
      this.device.regionName = response.region_name;
    },
    async deleteDevice(id, deviceName) {
      const payload = {
        id: id,
      }
      if (confirm(`Do you really want to delete device ${deviceName}?`)) {
        this.messageProps.message = await deleteObject('device', `/device/${this.$route.params.id}/delete`, payload);
        if (this.messageProps.message.sucsess) {
          alert(this.messageProps.message.sucsess);
          this.$router.push('/units/' + this.device.rackId);
        }
      }
    },
  }
}
</script>
