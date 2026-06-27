<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus } from '@lucide/vue';
import DeleteActionButton from '@/components/DeleteActionButton.vue';
import {
    Table,
    TableBody,
    TableCaption,
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

defineProps<{
    posts: {
        data: Post[];
    };
}>();

const deletePost = (id: number) => {
    router.delete(postsRoutes.destroy(id));
};
</script>

<template>
    <Head title="Posts" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div
            class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
            <div class="flex justify-end p-4">
                <Link :href="postsRoutes.create()"
                    class="flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm text-primary-foreground hover:bg-primary/90">
                    <Plus class="h-4 w-4" />

                    Crear Post
                </Link>
            </div>

            <Table>
                <TableCaption> Lista de posts registrados. </TableCaption>

                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[80px]"> ID </TableHead>

                        <TableHead> Título </TableHead>

                        <TableHead> Estado </TableHead>

                        <TableHead> Creado </TableHead>

                        <TableHead class="text-center"> Acciones </TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow v-for="post in posts.data" :key="post.id">
                        <TableCell class="font-medium">
                            {{ post.id }}
                        </TableCell>

                        <TableCell>
                            {{ post.title }}
                        </TableCell>

                        <TableCell>
                            {{ post.active ? 'Publicado' : 'Borrador' }}
                        </TableCell>

                        <TableCell>
                            {{ new Date(post.created_at).toLocaleDateString('es-AR') }}
                        </TableCell>

                        <TableCell>
                            <div class="flex justify-center gap-3">
                                <TooltipProvider :delay-duration="200">
                                    <Tooltip>
                                        <TooltipTrigger as-child>
                                            <Link :href="postsRoutes.edit(post.id)"
                                                class="text-blue-500 transition hover:text-blue-700">
                                                <Pencil class="h-5 w-5" />
                                            </Link>
                                        </TooltipTrigger>

                                        <TooltipContent> Editar registro </TooltipContent>
                                    </Tooltip>
                                </TooltipProvider>

                                <DeleteActionButton :id="post.id" @confirm="deletePost" />
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
