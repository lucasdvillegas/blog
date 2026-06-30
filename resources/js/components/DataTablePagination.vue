<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight } from '@lucide/vue';
import { Button } from '@/components/ui/button';

import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';

interface Pagination {
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
  from?: number | null;
  to?: number | null;
}

const props = defineProps<{
  pagination: Pagination;
  route: string;
}>();

const goToPage = (page: number) => {
  router.get(
    props.route,
    {
      page,
      per_page: props.pagination.per_page,
    },
    {
      preserveScroll: true,
    },
  );
};

const changePerPage = (value: any) => {
  if (!value) {
    return;
  }

  // Convierte cualquier valor a número
  const numericValue = Number(value);

  if (isNaN(numericValue)) {
    return;
  }

  router.get(
    props.route,
    {
      page: 1,
      per_page: numericValue,
    },
    {
      preserveScroll: true,
    },
  );
};

const pages = () => {
  const total = props.pagination.last_page;

  return Array.from(
    {
      length: total,
    },
    (_, index) => index + 1,
  );
};
</script>

<template>
  <div class="flex items-center justify-between p-4">
    <div class="flex items-center gap-4 text-sm">
      <span>
        {{ pagination.from ?? 0 }}
        -
        {{ pagination.to ?? 0 }}
        de
        {{ pagination.total }}
        registros
      </span>

      <Select
        :model-value="String(pagination.per_page)"
        @update:model-value="changePerPage"
      >
        <SelectTrigger class="w-[90px]">
          <SelectValue />
        </SelectTrigger>

        <SelectContent>
          <SelectItem value="10"> 10 </SelectItem>

          <SelectItem value="15"> 15 </SelectItem>

          <SelectItem value="20"> 20 </SelectItem>
        </SelectContent>
      </Select>
    </div>

    <div class="flex items-center gap-1">
      <Button
        variant="outline"
        size="sm"
        :disabled="pagination.current_page === 1"
        @click="goToPage(pagination.current_page - 1)"
      >
        <ChevronLeft class="h-4 w-4" />
      </Button>

      <Button
        v-for="page in pages()"
        :key="page"
        size="sm"
        :variant="
          page === pagination.current_page
            ? 'default'
            : 'outline'
        "
        @click="goToPage(page)"
      >
        {{ page }}
      </Button>

      <Button
        variant="outline"
        size="sm"
        :disabled="
          pagination.current_page === pagination.last_page
        "
        @click="goToPage(pagination.current_page + 1)"
      >
        <ChevronRight class="h-4 w-4" />
      </Button>
    </div>
  </div>
</template>
