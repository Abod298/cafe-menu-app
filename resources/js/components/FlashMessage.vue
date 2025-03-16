<template>
  <div class="w-full flex justify-center itesm-center mt-2">
    <div v-if="$page.props.flash.success"
        class="w-3/4 flex justify-center green-500 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
        role="alert">
        <p>{{ $page.props.flash.success }}</p>
    </div>
    <div v-else-if="$page.props.flash.error"
        class="w-3/4 flex justify-center red-500 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
        role="alert">
        <p>{{ $page.props.flash.error }}</p>
    </div>
</div>
</template>

<script>
export default {

}
</script>

<style>

</style>
