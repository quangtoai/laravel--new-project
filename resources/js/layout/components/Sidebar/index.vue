<template>
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <li class="sidebar-title">
        <!-- <img id="logo" src="../../../assets/images/logo.png" alt=""> -->
      </li>
      <ItemSidebar />
    </ul>
  </div>
</template>

<script>
import ItemSidebar from './ItemSidebar';

export default {
    name: 'Sidebar',
    components: {
        ItemSidebar,
    },
    data() {
        return {
            title: process.env.MIX_APP_TITLE,
        };
    },
};
</script>
