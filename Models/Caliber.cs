using System.ComponentModel.DataAnnotations;

namespace Gunventory.Models;

public class Caliber
{
    public int Id { get; set; }
    [Required]
    [MaxLength(1)]
    public string Status { get; set; } = "A";
    [Required]
    [MaxLength(15)]
    public string Name { get; set; } = string.Empty;
    public DateTime STimestamp { get; set; } = DateTime.Now;
}
