<template>
  <nav class="relative flex flex-wrap items-center justify-between px-2 py-3 bg-blue-800 mb-3">
    <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
      <img class="object-fill h-16 w-32" :src="mySVG" />
      <div class="lg:flex flex-grow items-center" id="example-navbar-warning">
        <ul class="flex flex-col lg:flex-row list-none ml-auto">
          <li class="nav-item">
            <router-link :to="{path: '/'}">
              <a class="px-3 py-2 flex items-center text-sm uppercase font-bold leading-snug text-white hover:opacity-75">
                Home
              </a>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{path: '/tree'}">
              <a class="px-3 py-2 flex items-center text-sm uppercase font-bold leading-snug text-white hover:opacity-75">
                Racks map
              </a>
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Header',
  data(){
    return {
      mySVG: require('@/assets/logo-svg.svg')
    }
  }
}
</script>
