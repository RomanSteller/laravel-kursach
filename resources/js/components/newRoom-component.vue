<template>
  <div class="container pt-5">
    <form action="" class="m-auto">
      <h3>Создать проект (комнату)</h3>
      <input type="text" class="form-control mt-2" placeholder="Название проекта" id="name_project">
      <input type="text" class="form-control mt-2" placeholder="Описание проекта" id="name_subject">
      <button type="button" class="btn btn-primary mt-2 w-100">Сохранить изменения</button>
    </form>
  </div>
</template>

<script>
export default {
  name: "newRoom-component"
}
</script>

<style scoped>

form{
  width: 450px;
}




</style>