<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Cart extends Model
    {
        use HasFactory;

        protected $fillable = ['user_id', 'test_id', 'price', 'quantity'];

        public function test()
        {
            return $this->belongsTo(Test::class, 'test_id');
        }
    }
?>