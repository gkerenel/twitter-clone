<script setup lang="ts">
    import AuthSigninForm from '@/components/AuthSigninForm.vue'
	import AuthContent from '@/components/AuthContent.vue'
    import AuthNavbar from '@/components/AuthNavbar.vue'
</script>

<template>
  <div class="min-h-screen bg-gray-50">
		<AuthNavbar long-description="Don't have an account?" short-description="Sign Up" url="/signup" />
		<AuthContent heading="Sign in to Twitter">
			<AuthSigninForm />
		</AuthContent>
	</div>
</template>
