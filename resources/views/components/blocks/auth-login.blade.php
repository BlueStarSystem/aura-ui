<section class="relative overflow-hidden py-20 sm:py-28">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-20 right-1/4 h-[400px] w-[400px] rounded-full bg-aura-primary-500/15 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/4 h-[300px] w-[300px] rounded-full bg-aura-secondary-500/10 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-sm px-4 sm:px-6">
        <div class="mb-8 text-center">
            <x-aura::badge variant="primary" rounded>Account</x-aura::badge>
            <h2 class="mt-4 font-heading text-3xl font-bold tracking-tight text-aura-surface-900 dark:text-white">
                Sign in to your account
            </h2>
            <p class="mt-2 text-sm text-aura-surface-500 dark:text-aura-surface-400">
                Don't have an account?
                <a href="#" class="font-medium text-aura-primary-600 hover:text-aura-primary-700 dark:text-aura-primary-400 dark:hover:text-aura-primary-300">
                    Create one free
                </a>
            </p>
        </div>

        <x-aura::card>
            <form method="POST" action="#">
                <div class="flex flex-col gap-5">
                    <x-aura::input
                        type="email"
                        name="email"
                        label="Email address"
                        placeholder="you@example.com"
                        autocomplete="email"
                        class="w-full max-w-full"
                    />

                    <div>
                        <div class="mb-1.5 flex items-center justify-between">
                            <span class="text-[13px] font-semibold text-aura-surface-900 tracking-tight">Password</span>
                            <a href="#" class="text-xs font-medium text-aura-primary-600 hover:text-aura-primary-700 dark:text-aura-primary-400 dark:hover:text-aura-primary-300">
                                Forgot password?
                            </a>
                        </div>
                        <x-aura::input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            class="w-full max-w-full"
                        />
                    </div>

                    <x-aura::checkbox name="remember" label="Remember me for 30 days" />

                    <x-aura::button type="submit" variant="primary" gradient class="w-full">
                        Sign in
                    </x-aura::button>
                </div>
            </form>

            <x-slot:footer>
                <div class="w-full text-center text-xs text-aura-surface-400 dark:text-aura-surface-500">
                    By signing in you agree to our
                    <a href="#" class="text-aura-primary-600 hover:underline dark:text-aura-primary-400">Terms</a>
                    and
                    <a href="#" class="text-aura-primary-600 hover:underline dark:text-aura-primary-400">Privacy Policy</a>.
                </div>
            </x-slot:footer>
        </x-aura::card>
    </div>
</section>
