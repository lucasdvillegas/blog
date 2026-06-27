<script setup lang="ts">
import { Head, router, Link } from '@inertiajs/vue3';
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import { toast } from 'vue-sonner';
import * as yup from 'yup';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Textarea } from '@/components/ui/textarea';
import postsRoutes from '@/routes/posts';
import type { Post } from '@/types';

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

const saving = ref(false);

const schema = yup.object({
  title: yup
    .string()
    .required()
    .min(3)
    .max(255)
    .label('Title'),

  slug: yup
    .string()
    .required()
    .min(3)
    .max(255)
    .label('Slug'),

  description: yup
    .string()
    .required()
    .min(10)
    .max(500)
    .label('Description'),

  content: yup
    .string()
    .required()
    .min(20)
    .max(10000)
    .label('Content'),

  active: yup.boolean().required().label('Active'),
});

const { handleSubmit, defineField, errors, setErrors } =
  useForm({
    validationSchema: schema,

    initialValues: {
      title: props.post.title,
      slug: props.post.slug,
      description: props.post.description,
      content: props.post.content,
      active: props.post.active,
    },
  });

const [title] = defineField('title');
const [slug] = defineField('slug');
const [description] = defineField('description');
const [content] = defineField('content');
const [active] = defineField('active');

const submit = handleSubmit((values) => {
  saving.value = true;

  router.put(
    postsRoutes.update.url(props.post.id), values, {
      preserveScroll: true,
      onSuccess: () => {
        toast.success('Post actualizado correctamente');
      },
      onError: (errors) => {
        setErrors(errors);
        toast.success(
          'Error al intentar actualizar el post',
        );
        console.log(errors);
      },
      onFinish: () => {
        saving.value = false;
      },
    },
  );
});
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
        <h1 class="text-xl font-semibold">Editar Post</h1>

        <p class="text-sm text-muted-foreground">
          Modifica la información del artículo.
        </p>
      </div>

      <form class="space-y-6" @submit="submit">
        <div class="grid gap-2">
          <Label for="title"> Título </Label>

          <Input id="title" v-model="title" />

          <InputError :message="errors.title" />
        </div>

        <div class="grid gap-2">
          <Label for="slug"> Slug </Label>

          <Input id="slug" v-model="slug" />

          <InputError :message="errors.slug" />
        </div>

        <div class="grid gap-2">
          <Label for="description"> Descripción </Label>

          <Input id="description" v-model="description" />

          <InputError :message="errors.description" />
        </div>

        <div class="grid gap-2">
          <Label for="content"> Contenido </Label>

          <Textarea
            id="content"
            v-model="content"
            class="min-h-[200px]"
          />

          <InputError :message="errors.content" />
        </div>

        <div class="flex items-center gap-2">
          <Checkbox id="active" v-model="active" />

          <Label for="active"> Publicado </Label>

          <InputError :message="errors.active" />
        </div>

        <div class="flex items-center gap-4">
          <Button
            type="submit"
            :disabled="saving"
            class="cursor-pointer"
          >
            <Spinner v-if="saving" />

            Actualizar
          </Button>

          <Button
            as-child
            variant="outline"
            :disabled="saving"
          >
            <Link :href="postsRoutes.index()">
              Cancelar
            </Link>
          </Button>
        </div>
      </form>
    </div>
  </div>
</template>
