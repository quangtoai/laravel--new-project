<template>
  <div>
    <li v-for="(item, index) in items" :key="index" ref="ListRoutes">
      <div>
        <router-link :to="item.path">
          <i :class="item.meta.icon" />
          <span>{{ $t(item.meta.title) }}</span>
        </router-link>
      </div>
    </li>

  </div>
</template>

<script>
export default {
    data() {
        return {
            items: [],
            menu: ['PayslipMe', 'Employee'],
        };
    },
    computed: {
        routes() {
            return this.$router.options.routes;
        },
        isRouteChange() {
            return this.$route.meta.title;
        },
    },
    watch: {
        isRouteChange() {
            const currentRoute = this.$route.meta.title;
            this.handleActiveClass(this.$t(currentRoute));
        },
    },
    created() {
        if (this.$store.state.user.auth.isManager){
            this.menu = ['PayslipIndex', 'Employee', 'PayslipImport'];
        }
        this.fetchMenuData(this.menu);
        // Get all routes in sotore
        // this.routes.forEach(route => {
        //     // Check route hidden
        //     if (!route.hidden) {
        //         // Check routes has many children
        //         if (route.children) {
        //             // Get nest router (route father)
        //             var isNest = route.path;
        //             // If children = 1 => children = main
        //             if (route.children.length === 1) {
        //                 // Check children is hidden or not => If not push to routes
        //                 if (route.children.hidden !== true) {
        //                     this.items.push({
        //                         path: `${isNest}/${route.children[0].path}`,
        //                         name: route.children[0].meta.title,
        //                         icon: route.children[0].meta.icon,
        //                         hasChildren: false,
        //                     });
        //                 }
        //             } else {
        //                 // If children > 1 => push routes
        //                 var newchildren = [];
        //                 var coutChildrenNotHidden = 0;
        //                 // Loop to get all children
        //                 route.children.forEach((children) => {
        //                     if (!children.hidden) {
        //                         newchildren.push({
        //                             path: `${isNest}/${children.path}`,
        //                             name: children.meta.title,
        //                             icon: children.meta.icon,
        //                         });

        //                         coutChildrenNotHidden = coutChildrenNotHidden + 1;
        //                     }
        //                 });

        //                 if (coutChildrenNotHidden < 2) {
        //                     this.items.push({
        //                         path: route.path,
        //                         name: route.meta.title,
        //                         icon: route.meta.icon,
        //                         hasChildren: false,
        //                         children: newchildren,
        //                     });
        //                 } else if (coutChildrenNotHidden >= 2) {
        //                     this.items.push({
        //                         path: route.path,
        //                         name: route.meta.title,
        //                         icon: route.meta.icon,
        //                         hasChildren: true,
        //                         children: newchildren,
        //                     });
        //                 }
        //             }
        //         } else {
        //             this.items.push({
        //                 path: route.path,
        //                 name: route.meta.title,
        //                 icon: route.meta.icon,
        //                 hasChildren: false,
        //             });
        //         }
        //     }
        // });
    },
    mounted() {
        const currentRoute = this.$route.meta.title;

        this.handleActiveClass(this.$t(currentRoute));
    },
    methods: {
        fetchMenuData(menu){
            const items = [];
            for (const item of menu){
                for (const route of this.routes) {
                    if (route.name === item) {
                        items.push(route);
                        continue;
                    }
                    if (route.children){
                        const child = route.children.find(c => c.name === item);
                        if (child){
                            child.path = route.path + '/' + child.path;
                            items.push(child);
                        }
                    }
                }
            }
            this.items = items;
        },
        handleActiveClass(text) {
            const listRoutes = this.$refs.ListRoutes;
            const listTextRoute = [];
            const lengthRoute = this.$refs.ListRoutes.length;
            text = ' ' + text;

            for (let indexRoute = 0; indexRoute < lengthRoute; indexRoute++) {
                listTextRoute.push(listRoutes[indexRoute].innerText);
            }

            // Remove class active
            for (let indexRoute = 0; indexRoute < lengthRoute; indexRoute++) {
                const CLASS_ACTIVE = 'active';

                const el = listRoutes[indexRoute].classList.value;

                const isExit = el.includes(CLASS_ACTIVE);

                if (isExit) {
                    this.$refs.ListRoutes[indexRoute].classList.remove('active');
                }
            }

            // Add class active
            for (let indexRoute = 0; indexRoute < lengthRoute; indexRoute++) {
                if (listTextRoute[indexRoute] === text) {
                    this.$refs.ListRoutes[indexRoute].classList.add('active');

                    break;
                }
            }
        },
    },
};
</script>
