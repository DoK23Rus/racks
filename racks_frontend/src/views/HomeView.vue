<template>
  <div class="min-h-screen">
    <div class="text-lg font-sans font-light my-auto items-center flex flex-col pt-8">
      <br>
        <text class="text-4xl pb-8 font-thin">Welcome {{ username.user }}!</text>
      <br>
      <div class="pb-4 text-base">
        <button id="e2e_racks_map" class="text-white w-48  bg-blue-400 border-b-4 border-blue-700 hover:border-blue-500
        hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base 
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit" @click="$router.push('/tree')">
          Racks map
        </button>
      <br>
        <button class="text-white w-48  bg-blue-400 border-b-4 border-blue-700 hover:border-blue-500
        hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base 
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit" id="button" @click="downloadDevices">
          Export devices
        </button>
      <br>
        <button class="text-white w-48 bg-blue-400 border-b-4 border-blue-700 hover:border-blue-500
        hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base 
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit" id="button" @click="downloadRacks">
          Export racks
        </button>
      <br>
        <button class="text-white w-48 bg-blue-400 border-b-4 border-blue-700 hover:border-blue-500
        hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base 
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit" id="button" @click="logout">
          Logout
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { getObject, getUser } from '@/api';


export default {
  name: 'HomeView',
  data() {  
      return {
        data: {},
        username: '',
        mySVG: require('@/assets/logo-svg.svg')
      }
  },
  created() {
    this.fetchUser();
  },
  methods: {
    logout() {
      localStorage.removeItem("token");
      this.$router.push('/login');
    },
    async getDevices() {
      const response = await getObject('devices', '/devices');
      return response;
    },
    async getRacks() {
      const response = await getObject('racks', '/racks');
      return response;
    },
    async fetchUser () {
      this.username = await getUser('username');
    },
    // Report funcs
    convertToCSV(objArray) {
      // Get csv
      const array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
      let str = '';
      for (let i = 0; i < array.length; i++) {
        let line = '';
        for (let index in array[i]) {
          if (line != '') line += ','
          line += array[i][index];
        }
        str += line + '\r\n';
      }
      return str;
    },
    exportCSVFile(headers, items, fileTitle) {
      // Export file
      if (headers) {
        items.unshift(headers);
      }
      const jsonObject = JSON.stringify(items);
      const csv = this.convertToCSV(jsonObject);
      const exportedFilenmae = fileTitle + '.csv' || 'export.csv';
      const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
      if (navigator.msSaveBlob) {
        navigator.msSaveBlob(blob, exportedFilenmae);
      } else {
        var link = document.createElement("a");
        if (link.download !== undefined) {
          const url = URL.createObjectURL(blob);
          link.setAttribute("href", url);
          link.setAttribute("download", exportedFilenmae);
          link.style.visibility = 'hidden';
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        }
      }
    },
    async downloadDevices() {
      // Get devices data
      const headers = {
        id: 'Device number',
        first_unit: 'First unit',
        last_unit: 'Last unit',
        frontside_location: 'Installed on the front',
        status: 'Device status',
        device_type: 'Device type',
        device_vendor: 'Device vendor',
        device_model: 'Device model',
        device_hostname: 'Hostname',
        ip: 'IP-address',
        device_stack: 'Stack/Reserve',
        ports_amout: 'Port capacity',
        version: 'Software version',
        power_type: 'Socket type',
        power_w: 'Power requirement (W)',
        power_v: 'Voltage (V)',
        power_ac_dc: 'AC/DC',
        device_serial_number: 'Serial number',
        device_description: 'Description',
        project: 'Project',
        ownership: 'Ownership',
        responsible: 'Responsible',
        financially_responsible_person: 'Financially responsible',
        device_inventory_number: 'Inventory number',
        fixed_asset: 'Fixed asset',
        updated_by: 'Updated by',
        updated_at: 'Updated at',
        rack_id: 'Rack ID',
        link_to_device: 'Link to device card',
        rack_name: 'Rack',
        room_name: 'Room',
        building_name: 'Building',
        site_name: 'Site',
        department_name: 'Department',
        region_name: 'Region'
      };
      const itemsNotFormatted = await this.getDevices();
      let itemsFormatted = [];
      itemsNotFormatted.forEach((item) => {
        itemsFormatted.push({
          id: item.id,
          first_unit: item.first_unit,
          last_unit: item.last_unit,
          frontside_location: item.frontside_location ? 'Yes' : 'No',
          status: item.status,
          device_type: item.device_type,
          device_vendor: item.device_vendor,
          device_model: item.device_model,
          device_hostname: item.device_hostname,
          ip: item.ip ? item.ip : '',
          device_stack: item.device_stack ? `${process.env.VUE_APP_REPORT_URL}/device/${item.device_stack}` : '',
          ports_amout: item.ports_amout ? item.ports_amout : '',
          version: item.version,
          power_type: item.power_type ? item.power_type : '',
          power_w: item.power_w ? item.power_w : '',
          power_v: item.power_v ? item.power_v : '',
          power_ac_dc: item.power_ac_dc,
          device_serial_number: item.device_serial_number,
          device_description: item.device_description,
          project: item.project,
          ownership: item.ownership,
          responsible: item.responsible,
          financially_responsible_person: item.financially_responsible_person,
          device_inventory_number: item.device_inventory_number,
          fixed_asset: item.fixed_asset,
          updated_by: item.updated_by,
          updated_at: item.updated_at,
          rack_id: item.rack_id,
          link_to_device: `${process.env.VUE_APP_REPORT_URL}/device/${item.id}`,
          rack_name: item.rack_name,
          room_name: item.room_name,
          building_name: item.building_name,
          site_name: item.site_name,
          department_name: item.department_name,
          region_name: item.region_name
        });
      });
      const fileTitle = 'devices';
      this.exportCSVFile(headers, itemsFormatted, fileTitle);
    },
    async downloadRacks() {
      // Get racks data
      const headers = {
        id: 'Rack number',
        rack_name: 'Rack name',
        rack_amount: 'Rack amount (units)',
        rack_vendor: 'Device vendor',
        rack_model: 'Device model',
        rack_description: 'Description',
        numbering_from_bottom_to_top: 'Numbering from bottom to top',
        responsible: 'Responsible',
        rack_financially_responsible_person: 'Financially responsible',
        rack_inventory_number: 'Inventory number',
        fixed_asset: 'Fixed asset',
        link: 'Link to docs',
        row: 'Row',
        place: 'Place',
        rack_height: 'Rack height (mm)',
        rack_width: 'Rack width (mm)',
        rack_depth: 'Rack depth (mm)',
        rack_unit_width: 'Useful rack width (inches)',
        rack_unit_depth: 'Useful rack depth (mm)',
        rack_type: 'Execution variant',
        rack_frame: 'Construction',
        rack_palce_type: 'Location type',
        max_load: 'Max load (kilo)',
        power_sockets: 'Free power sockets',
        power_sockets_ups: 'Free UPS power sockets',
        external_ups: 'External power backup supply system',
        cooler: 'Active ventilation',
        updated_by: 'Updated by',
        updated_at: 'Updated at',
        room_id: 'Room id',
        link_to_device: 'Link to rack card',
        room_name: 'Room',
        building_name: 'Building',
        site_name: 'Site',
        department_name: 'Department',
        region_name: 'Region'
      };
      const itemsNotFormatted = await this.getRacks();
      let itemsFormatted = [];
      itemsNotFormatted.forEach((item) => {
        itemsFormatted.push({
          id: item.id,
          rack_name: item.rack_name,
          rack_amount: item.rack_amount,
          rack_vendor: item.rack_vendor,
          rack_model: item.rack_model,
          rack_description: item.rack_description,
          numbering_from_bottom_to_top: item.numbering_from_bottom_to_top ? 'Yes' : 'No',
          responsible: item.responsible,
          rack_financially_responsible_person: item.rack_financially_responsible_person,
          rack_inventory_number: item.rack_inventory_number,
          fixed_asset: item.fixed_asset,
          link: item.link,
          row: item.row,
          place: item.place,
          rack_height: item.rack_height ? item.rack_height : '',
          rack_width: item.rack_width ? item.rack_width : '',
          rack_depth: item.rack_depth ? item.rack_depth : '',
          rack_unit_width: item.rack_unit_width ? item.rack_unit_width : '',
          rack_unit_depth: item.rack_unit_depth ? item.rack_unit_depth : '',
          rack_type: item.rack_type,
          rack_frame: item.rack_frame,
          rack_palce_type: item.rack_palce_type,
          max_load: item.max_load ? item.max_load : '',
          power_sockets: item.power_sockets ? item.power_sockets : '',
          power_sockets_ups: item.power_sockets_ups ? item.power_sockets_ups : '',
          external_ups: item.external_ups ? 'Yes' : 'No',
          cooler: item.cooler ? 'Yes' : 'No',
          updated_by: item.updated_by,
          updated_at: item.updated_at,
          room_id: item.room_id,
          link_to_rack: `${process.env.VUE_APP_REPORT_URL}/rack/${item.id}`,
          room_name: item.room_name,
          building_name: item.building_name,
          site_name: item.site_name,
          department_name: item.department_name,
          region_name: item.region_name
        });
      });
      const fileTitle = 'racks';
      this.exportCSVFile(headers, itemsFormatted, fileTitle);
    }
  }
}
</script>
