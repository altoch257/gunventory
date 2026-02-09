using System.ComponentModel.DataAnnotations;

namespace Gunventory.Models;

public class MaintenanceType
{
    public int Id { get; set; }
    [Required]
    [MaxLength(1)]
    public string Status { get; set; } = "A";
    [Required]
    [MaxLength(50)]
    public string Name { get; set; } = string.Empty;
}
