<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\TelegramBotController;

class TelegramPoll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Long poll Telegram updates for local development';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Telegram Long Polling...');
        // Controller moved inside loop to pick up changes dynamically
        
        // Remove webhook to enable polling
        try {
            Telegram::removeWebhook();
            $this->info('Webhook removed.');
        } catch (\Exception $e) {
            $this->warn('Could not remove webhook: ' . $e->getMessage());
        }

        $offset = 0;
        
        while (true) {
            try {
                $updates = Telegram::getUpdates(['offset' => $offset + 1, 'timeout' => 30]);
                
                foreach ($updates as $update) {
                    $this->info('Received Update ID: ' . $update->getUpdateId());
                    $offset = $update->getUpdateId();
                    
                    if ($update->has('message')) {
                        $message = $update->getMessage();
                        
                        // Handle Text or Photo (with potential caption)
                        if ($message->has('text') || $message->has('photo')) {
                            $text = $message->getText() ?? $message->getCaption() ?? ''; // Fallback to caption if photo
                            $chatId = $message->getChat()->getId();
                            $username = $message->getFrom()->getUsername() ?? 'Unknown';
                            
                            $type = $message->has('photo') ? 'Photo' : 'Text';
                            $this->info("$type Message: $text from $chatId ($username)");
                            
                            // Pass full update object to controller
                            $controller = new TelegramBotController();
                            $controller->processMessage($text, $chatId, $update);
                        }
                    } elseif ($update->has('callback_query')) {
                        $callback = $update->getCallbackQuery();
                        $data = $callback->getData();
                        $chatId = $callback->getMessage()->getChat()->getId();
                        $username = $callback->getFrom()->getUsername() ?? 'Unknown';
                        
                        $this->info("Callback: $data from $chatId ($username)");
                        
                        $controller = new TelegramBotController();
                        $controller->processCallback($callback);
                    }
                }
            } catch (\Exception $e) {
                $this->error('Error: ' . $e->getMessage());
                sleep(5);
            }
            
            // Sleep slightly to prevent tight loop if timeout fails
            usleep(500000); // 0.5s
        }
    }
}
