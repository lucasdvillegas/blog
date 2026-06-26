<script setup lang="ts">
import {
  Head,
  useForm,
  Link
} from '@inertiajs/vue3';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import postsRoutes from '@/routes/posts';
import type { Post } from '@/types';
import { Textarea } from '@/components/ui/textarea';

const props = defineProps<{
  post: Post;
}>();

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: 'Posts',
        href: postsRoutes.index(),
      },
      {
        title: 'Editar',
        href: postsRoutes.index(),
      },
    ],
  },
});

const form = useForm({
  title: props.post.title,
  slug: props.post.slug,
  description: props.post.description,
  content: props.post.content,
  active: props.post.active,
});

const submit = () => {
  form.put(postsRoutes.update.url(props.post.id),
    {
      preserveScroll: true,

      onSuccess: () => {
        console.log('Post actualizado');
      },

      onError: (errors) => {
        console.log(errors);
      },
    },
  );
};
</script>

<template>
  <Head title="Editar Post" />

  <div
    class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4"
  >
    <div
      class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 p-6 md:min-h-min dark:border-sidebar-border"
    >
      <div class="mb-6">
        <h1
          class="text-xl font-semibold"
        >
          Editar Post
        </h1>

        <p
          class="text-sm text-muted-foreground"
        >
          Modifica la información del
          artículo.
        </p>
      </div>

      <form
        class="space-y-6"
        @submit.prevent="submit"
      >
        <div class="grid gap-2">
          <Label for="title">
            Título
          </Label>

          <Input
            id="title"
            v-model="form.title"
            placeholder="Título del post"
          />

          <InputError
            :message="form.errors.title"
          />
        </div>

        <div class="grid gap-2">
          <Label for="slug">
            Slug
          </Label>

          <Input
            id="slug"
            v-model="form.slug"
            placeholder="mi-primer-post"
          />

          <InputError
            :message="form.errors.slug"
          />
        </div>

        <div class="grid gap-2">
          <Label for="description">
            Descripción
          </Label>

          <Input
            id="description"
            v-model="form.description"
            placeholder="Breve descripción del artículo"
          />

          <InputError
            :message="
              form.errors.description
            "
          />
        </div>

        <div class="grid gap-2">
          <Label for="content">
            Contenido
          </Label>

          <Textarea
            id="content"
            v-model="form.content"
            class="min-h-[200px]"
            placeholder="Contenido del post"
          />

          <InputError
            :message="
              form.errors.content
            "
          />
        </div>

        <div
          class="flex items-center gap-2"
        >
          <input
            id="active"
            v-model="form.active"
            type="checkbox"
            class="h-4 w-4"
          />

          <Label for="active">
            Publicado
          </Label>
        </div>

        <div
          class="flex items-center gap-4"
        >
          <Button
            type="submit"
            :disabled="form.processing"
          >
            <Spinner v-if="form.processing" />
            Actualizar
          </Button>

          <Button
            as-child
            variant="outline"
            :disabled="form.processing"
          >
            <Link
              :href="
                postsRoutes.index()
              "
            >
              Cancelar
            </Link>
          </Button>
        </div>
      </form>
    </div>
  </div>
</template>
