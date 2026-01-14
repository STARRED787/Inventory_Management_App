<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { addItem } from '@/page-routes/add-item';
import { createItem } from '@/page-routes/create-item';
import { DeductItem } from '@/page-routes/deduct-item';
import { HistoryItem } from '@/page-routes/history-item';
import { SearchItem } from '@/page-routes/search-item';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
    ArrowDownToLine,
    ArrowUpFromLine,
    BookOpen,
    Folder,
    History,
    PackagePlus,
    Search,
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Create Item',
        href: createItem(),
        icon: PackagePlus,
    },
    {
        title: 'Add Items',
        href: addItem(),
        icon: ArrowDownToLine,
    },
    {
        title: 'Deduct Items',
        href: DeductItem(),
        icon: ArrowUpFromLine,
    },
    {
        title: 'Item History',
        href: HistoryItem(),
        icon: History,
    },
    {
        title: 'Item Search',
        href: SearchItem(),
        icon: Search,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="createItem()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
