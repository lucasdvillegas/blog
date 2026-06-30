<script setup lang="ts">
import {
  Head,
  Link,
  router,
  usePage,
} from '@inertiajs/vue3';
import { Pencil, Plus, Info, Search } from '@lucide/vue';
import { ref, watch } from 'vue';

import DataTablePagination from '@/components/DataTablePagination.vue';
import DeleteActionButton from '@/components/DeleteActionButton.vue';
import { Input } from '@/components/ui/input';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';

import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';

import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from '@/components/ui/tooltip';

import postsRoutes from '@/routes/posts';
import type { Post } from '@/types';

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: 'Posts',
        href: postsRoutes.index(),
      },
    ],
  },
});

const props = defineProps<{
  posts: {
    data: Post[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
  };
}>();

const page = usePage();

const search = ref<string>(
  (page.props.filters as any)?.search ?? '',
);

const status = ref<'all' | '1' | '0'>(
  (page.props.filters as any)?.status ?? 'all',
);

watch(
  () => page.props.filters,
  (filters: any) => {
    search.value = filters?.search ?? '';
    status.value = filters?.status ?? 'all';
  },
);

const applyFilters = (extra: Record<string, any> = {}) => {
  router.get(
    postsRoutes.index.url(),
    {
      search: search.value || undefined,
      status:
        status.value === 'all' ? undefined : status.value,
      page: 1,
      per_page: props.posts.per_page,
      ...extra,
    },
    {
      preserveScroll: true,
      preserveState: false,
      replace: true,
    },
  );
};

const deletePost = (id: number) => {
  router.delete(postsRoutes.destroy(id));
};
</script>
<template>
  <Head title="Posts" />

  <div
    class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4"
  >
    <div
      class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
    >
      <div class="flex items-center justify-between p-4">
        <Link
          :href="postsRoutes.create()"
          class="flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm text-primary-foreground hover:bg-primary/90"
        >
          <Plus class="h-4 w-4" />
          Crear Post
        </Link>

        <div class="flex items-center gap-2">
          <div class="relative w-[220px]">
            <Search
              class="absolute top-1/2 left-2 h-4 w-4 -translate-y-1/2 text-muted-foreground"
            />

            <Input
              v-model="search"
              placeholder="Buscar"
              class="pr-8 pl-8"
              @input="applyFilters()"
            />

            <TooltipProvider>
              <Tooltip>
                <TooltipTrigger as-child>
                  <Info
                    class="absolute top-1/2 right-2 h-4 w-4 -translate-y-1/2 cursor-help text-muted-foreground"
                  />
                </TooltipTrigger>

                <TooltipContent side="top">
                  Buscar por título o fecha
                </TooltipContent>
              </Tooltip>
            </TooltipProvider>
          </div>

          <Select
            v-model="status"
            @update:model-value="applyFilters()"
          >
            <SelectTrigger class="w-[160px] cursor-pointer">
              <SelectValue placeholder="Estado" />
            </SelectTrigger>

            <SelectContent>
              <SelectItem value="all">Todos</SelectItem>
              <SelectItem value="1">Activo</SelectItem>
              <SelectItem value="0">Inactivo</SelectItem>
            </SelectContent>
          </Select>
        </div>
      </div>

      <Table>
        <TableHeader>
          <TableRow>
            <TableHead class="pl-4 text-left"
              >Título</TableHead
            >
            <TableHead>Estado</TableHead>
            <TableHead>Creado</TableHead>
            <TableHead class="pr-4 text-right"
              >Acciones</TableHead
            >
          </TableRow>
        </TableHeader>

        <TableBody>
          <TableRow
            v-for="post in posts.data"
            :key="post.id"
          >
            <TableCell class="pl-4 text-left">
              {{ post.title }}
            </TableCell>

            <TableCell>
              {{ post.active ? 'Publicado' : 'Borrador' }}
            </TableCell>

            <TableCell>
              {{
                new Date(
                  post.created_at,
                ).toLocaleDateString('es-AR')
              }}
            </TableCell>

            <TableCell>
              <div class="flex justify-end gap-2 pr-2">
                <TooltipProvider :delay-duration="200">
                  <Tooltip>
                    <TooltipTrigger as-child>
                      <Link
                        :href="postsRoutes.edit(post.id)"
                        class="text-blue-500 transition hover:text-blue-700"
                      >
                        <Pencil class="h-5 w-5" />
                      </Link>
                    </TooltipTrigger>

                    <TooltipContent
                      >Editar registro</TooltipContent
                    >
                  </Tooltip>
                </TooltipProvider>

                <DeleteActionButton
                  :id="post.id"
                  @confirm="deletePost"
                />
              </div>
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>

      <DataTablePagination
        :pagination="props.posts"
        :route="postsRoutes.index.url()"
        :filters="{
          search,
          status,
        }"
      />
    </div>
  </div>
</template>
