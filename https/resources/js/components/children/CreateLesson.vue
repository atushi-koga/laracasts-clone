<template>
	<div class="modal fade" id="createLesson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h5 class="modal-title" id="exampleModalLabel">Create new lesson</h5>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	          </button>
	        </div>
	        <div class="modal-body">
		         <div class="form-group">
	              <input type="text" class="form-control" placeholder="Lesson title">
	            </div>
	            <div class="form-group">
	              <input type="text" class="form-control" placeholder="Vimeo video id">
	            </div>
	            <div class="form-group">
	              <input type="number" class="form-control" placeholder="Episode number">
	            </div>

	            <div class="form-group">
	            	<textarea cols="30" rows="10" class="form-control"></textarea>
	            </div>
                <div class="form-group">
	            	<input type="checkbox">Premium:
	            </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	          <button type="button" class="btn btn-primary">Save lesson</button>
	          <button type="button" class="btn btn-primary">Create lesson</button>
	        </div>
	      </div>
	    </div>
	  </div>
</template>

<script>
    export default {
        mounted(){
            this.$parent.$on('create-new-lesson', () => {
                console.log('hello parents')
                $('#createLesson').modal()
            })
        }
    }
</script>

