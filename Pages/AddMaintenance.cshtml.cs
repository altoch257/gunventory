using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Gunventory.Data;
using Gunventory.Models;
using Microsoft.AspNetCore.Authorization;
using System.ComponentModel.DataAnnotations;

namespace Gunventory.Pages;

[Authorize]
public class AddMaintenanceModel : PageModel
{
    private readonly GunventoryContext _context;

    public AddMaintenanceModel(GunventoryContext context)
    {
        _context = context;
    }

    [BindProperty]
    public InputModel Input { get; set; } = new();

    public SelectList Firearms { get; set; } = default!;
    public SelectList MaintenanceTypes { get; set; } = default!;

    public class InputModel
    {
        [Required]
        public int FirearmId { get; set; }

        [Required]
        public int MaintenanceTypeId { get; set; }

        [Required]
        [DataType(DataType.Date)]
        public DateTime Date { get; set; } = DateTime.Now;

        [MaxLength(255)]
        public string? Details { get; set; }
    }

    public void OnGet()
    {
        Firearms = new SelectList(_context.Firearms.Where(f => f.Status == "A"), "Id", "Model");
        MaintenanceTypes = new SelectList(_context.MaintenanceTypes.Where(m => m.Status == "A"), "Id", "Name");
    }

    public async Task<IActionResult> OnPostAsync()
    {
        if (!ModelState.IsValid)
        {
            Firearms = new SelectList(_context.Firearms.Where(f => f.Status == "A"), "Id", "Model");
            MaintenanceTypes = new SelectList(_context.MaintenanceTypes.Where(m => m.Status == "A"), "Id", "Name");
            return Page();
        }

        var maintenance = new Maintenance
        {
            FirearmId = Input.FirearmId,
            MaintenanceTypeId = Input.MaintenanceTypeId,
            Date = Input.Date,
            Details = Input.Details,
            Status = "A",
            STimestamp = DateTime.Now
        };

        _context.Maintenance.Add(maintenance);
        await _context.SaveChangesAsync();

        return RedirectToPage("/FirearmDetails", new { id = Input.FirearmId });
    }
}
